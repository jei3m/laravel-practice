import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add success message handling
window.addEventListener('load', function() {
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        setTimeout(function() {
            successMessage.remove();
        }, 3000);
    }
});