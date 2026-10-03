<style>
    #pwa-install-container {
        display: none;
        align-items: center;
        margin-right: 0.5rem;
    }
    #pwa-install-container.is-active {
        display: inline-flex !important;
    }
    .pwa-install-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #059669;
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        line-height: 1;
        outline: none;
    }
    .pwa-install-action-btn:hover {
        background-color: #d1fae5;
        border-color: #6ee7b7;
    }
    .dark .pwa-install-action-btn {
        color: #6ee7b7;
        background-color: rgba(6, 78, 59, 0.35);
        border-color: rgba(5, 150, 105, 0.5);
    }
    .dark .pwa-install-action-btn:hover {
        background-color: rgba(6, 78, 59, 0.6);
        border-color: #10b981;
    }
    #pwa-ios-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background-color: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(2px);
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    #pwa-ios-modal.is-open {
        display: flex !important;
    }
    .pwa-modal-box {
        background: #ffffff;
        border-radius: 1rem;
        max-width: 360px;
        width: 100%;
        padding: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        text-align: center;
        color: #1f2937;
        font-family: inherit;
    }
    .dark .pwa-modal-box {
        background: #1e293b;
        color: #f1f5f9;
        border: 1px solid #334155;
    }
</style>

<div id="pwa-install-container">
    <button
        id="pwa-install-btn"
        type="button"
        class="pwa-install-action-btn"
        title="Install Dainik Arthiki"
    >
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px; min-width: 15px;">
            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        <span>Install App</span>
    </button>
</div>

<!-- iOS Install Help Modal (strictly hidden unless opened) -->
<div id="pwa-ios-modal">
    <div class="pwa-modal-box">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                <line x1="12" y1="18" x2="12.01" y2="18"></line>
            </svg>
        </div>
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">Install on iPhone / iPad</h3>
        <p style="font-size: 0.8rem; line-height: 1.5; color: #64748b; margin-bottom: 1.25rem;">
            1. Tap the <strong style="color: inherit;">Share</strong> button (box with an arrow pointing up) at the bottom of Safari.<br>
            2. Scroll down and tap <strong style="color: inherit;">"Add to Home Screen"</strong>.
        </p>
        <button
            type="button"
            id="pwa-ios-close-btn"
            style="width: 100%; padding: 0.5rem 1rem; background: #10b981; color: #ffffff; font-size: 0.8rem; font-weight: 600; border: none; border-radius: 0.5rem; cursor: pointer;"
        >
            Got it
        </button>
    </div>
</div>

<script>
    (function() {
        let deferredPrompt = null;
        const container = document.getElementById('pwa-install-container');
        const installBtn = document.getElementById('pwa-install-btn');
        const iosModal = document.getElementById('pwa-ios-modal');
        const iosCloseBtn = document.getElementById('pwa-ios-close-btn');

        // Check if already in standalone PWA mode
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (isStandalone) {
            return;
        }

        const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        // Listen for Chrome/Edge/Android beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (container) {
                container.classList.add('is-active');
            }
        });

        // Show button on iOS as well
        if (isIos && container) {
            container.classList.add('is-active');
        }

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const choiceResult = await deferredPrompt.userChoice;
                    if (choiceResult.outcome === 'accepted') {
                        if (container) container.classList.remove('is-active');
                    }
                    deferredPrompt = null;
                } else if (isIos && iosModal) {
                    iosModal.classList.add('is-open');
                } else {
                    alert('To install, open your browser menu (⋮) and select "Install Dainik Arthiki" or "Add to Home Screen".');
                }
            });
        }

        if (iosCloseBtn && iosModal) {
            iosCloseBtn.addEventListener('click', () => {
                iosModal.classList.remove('is-open');
            });
        }

        window.addEventListener('appinstalled', () => {
            if (container) container.classList.remove('is-active');
            deferredPrompt = null;
        });
    })();
</script>
