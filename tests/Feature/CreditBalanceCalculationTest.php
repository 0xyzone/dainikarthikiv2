<?php

namespace Tests\Feature;

use App\Filament\App\Resources\Credits\Widgets\CreditOverview;
use App\Filament\App\Resources\People\Pages\ListPeople;
use App\Filament\App\Widgets\StatsOverview;
use App\Models\Credit;
use App\Models\Person;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreditBalanceCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_person_pending_balance_and_widget_calculations_handle_settled_and_overpaid_credits(): void
    {
        Filament::setCurrentPanel('app');
        $user = User::factory()->create();
        $this->actingAs($user);

        $alice = Person::create([
            'user_id' => $user->id,
            'name' => 'Alice',
        ]);

        $bob = Person::create([
            'user_id' => $user->id,
            'name' => 'Bob',
        ]);

        // Alice: given 1000, paid 400 -> 600 remaining to collect
        $givenPartial = Credit::create([
            'user_id' => $user->id,
            'person_id' => $alice->id,
            'type' => 'given',
            'amount' => 1000,
            'date' => now(),
            'status' => 'pending',
        ]);
        $givenPartial->payments()->create([
            'user_id' => $user->id,
            'amount' => 400,
            'payment_date' => now(),
            'payment_method' => 'Cash',
        ]);

        // Alice: given 500, manually marked settled without payment -> 0 remaining
        Credit::create([
            'user_id' => $user->id,
            'person_id' => $alice->id,
            'type' => 'given',
            'amount' => 500,
            'date' => now(),
            'status' => 'settled',
        ]);

        // Alice: taken 300, paid 500 (overpaid) -> 0 remaining
        $takenOverpaid = Credit::create([
            'user_id' => $user->id,
            'person_id' => $alice->id,
            'type' => 'taken',
            'amount' => 300,
            'date' => now(),
            'status' => 'pending',
        ]);
        $takenOverpaid->payments()->create([
            'user_id' => $user->id,
            'amount' => 500,
            'payment_date' => now(),
            'payment_method' => 'Cash',
        ]);

        // Bob: taken 800, paid 200 -> 600 remaining to repay
        $takenPartial = Credit::create([
            'user_id' => $user->id,
            'person_id' => $bob->id,
            'type' => 'taken',
            'amount' => 800,
            'date' => now(),
            'status' => 'pending',
        ]);
        $takenPartial->payments()->create([
            'user_id' => $user->id,
            'amount' => 200,
            'payment_date' => now(),
            'payment_method' => 'Cash',
        ]);

        // Bob: taken 250, manually marked settled -> 0 remaining
        Credit::create([
            'user_id' => $user->id,
            'person_id' => $bob->id,
            'type' => 'taken',
            'amount' => 250,
            'date' => now(),
            'status' => 'settled',
        ]);

        $this->assertEquals(600.00, $alice->pending_receivable);
        $this->assertEquals(0.00, $alice->pending_payable);
        $this->assertEquals(600.00, $alice->pending_balance);

        $this->assertEquals(0.00, $bob->pending_receivable);
        $this->assertEquals(600.00, $bob->pending_payable);
        $this->assertEquals(-600.00, $bob->pending_balance);

        // Total given remaining = 600, total taken remaining = 600 -> Net Position = +Rs. 0.00
        Livewire::test(CreditOverview::class)
            ->assertSee('600.00 remaining to collect')
            ->assertSee('600.00 remaining to repay')
            ->assertSee('+Rs. 0.00');

        // Dashboard StatsOverview: Credits (To Collect) = 600.00, Debts (To Repay) = 600.00
        Livewire::test(StatsOverview::class)
            ->assertSee('रु 600.00')
            ->assertSee('1 active receivable')
            ->assertSee('1 active payable');

        // Persons list table renders with Remaining Balance column
        Livewire::test(ListPeople::class)
            ->assertCanSeeTableRecords([$alice, $bob])
            ->assertSee('+Rs. 600.00')
            ->assertSee('-Rs. 600.00');
    }
}
