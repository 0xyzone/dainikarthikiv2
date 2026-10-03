<!-- PWA Manifest & Meta Tags -->
<link rel="manifest" href="/manifest.webmanifest">
<meta name="theme-color" content="#10b981">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Dainik Arthiki">
<meta name="application-name" content="Dainik Arthiki">

<!-- PWA Icons -->
<link rel="apple-touch-icon" sizes="180x180" href="/pwa-icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="192x192" href="/pwa-icons/icon-192x192.png">
<link rel="icon" type="image/png" sizes="512x512" href="/pwa-icons/icon-512x512.png">
<link rel="icon" type="image/svg+xml" href="/pwa-icons/icon.svg">

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
