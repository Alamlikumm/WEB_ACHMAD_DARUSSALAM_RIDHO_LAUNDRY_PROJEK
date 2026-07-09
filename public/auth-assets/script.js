document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');

    if(loginForm) {
        loginForm.addEventListener('submit', function() {
            // Add loading class to button to show spinner
            submitBtn.classList.add('loading');
            
            // Disable button to prevent double submission
            submitBtn.disabled = true;
            
            // Optional: you can re-enable it after a timeout if the request fails
            // (Laravel will reload the page anyway on success or validation error)
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 5000);
        });
    }
});
