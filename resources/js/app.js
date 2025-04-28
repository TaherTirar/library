// Custom JavaScript
document.addEventListener('DOMContentLoaded', () => {
    // Handle mobile menu toggle
    const menuToggle = document.querySelector('.navbar-toggler');
    const mobileMenu = document.querySelector('.navbar-collapse');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });
    }

    // Handle dropdowns
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                menu.classList.toggle('show');
            });
        }
    });
});
