@php
    $isLocalEnv = app()->environment('local');
    $faviconUrl = asset($isLocalEnv ? 'images/favicon-local.svg' : 'images/favicon-prod.svg');
@endphp

<!-- PWA Manifest & Meta Tags -->
<link rel="manifest" href="/manifest.webmanifest">
<meta name="theme-color" content="{{ $isLocalEnv ? '#f59e0b' : '#10b981' }}">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Dainik Arthiki">
<meta name="application-name" content="Dainik Arthiki">

<!-- Environment-Aware Favicon & PWA Icons -->
<link rel="icon" type="image/svg+xml" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" sizes="180x180" href="/pwa-icons/apple-touch-icon.png">

<!-- PWA Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js', { scope: '/' })
                .then(function(reg) {
                    console.log('Dainik Arthiki PWA Active:', reg.scope);
                })
                .catch(function(err) {
                    console.warn('PWA registration failed:', err);
                });
        });
    }
</script>
