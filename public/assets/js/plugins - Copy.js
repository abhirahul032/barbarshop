// assets/js/plugins.js
(function() {
    'use strict';
    
    // Define base path
    const basePath = window.assetPath || '/assets/';
    
    // Function to load scripts dynamically
    function loadScript(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        script.type = 'text/javascript';
        script.onload = callback;
        document.head.appendChild(script);
    }
    
    // Check conditions and load scripts
    if (document.querySelectorAll("[toast-list]").length > 0 || 
        document.querySelectorAll("[data-choices]").length > 0 || 
        document.querySelectorAll("[data-provider]").length > 0) {
        
        // Load Toastify if needed
        if (document.querySelectorAll("[toast-list]").length > 0) {
            loadScript(basePath + 'libs/toastify-js/toastify.js');
        }
        
        // Load Choices if needed
        if (document.querySelectorAll("[data-choices]").length > 0) {
            loadScript(basePath + 'libs/choices.js/public/assets/scripts/choices.min.js');
        }
        
        // Load Flatpickr if needed
        if (document.querySelectorAll("[data-provider]").length > 0) {
            loadScript(basePath + 'libs/flatpickr/flatpickr.min.js');
        }
    }
})();