import './bootstrap';
import '../css/app.css';

document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('user-menu-button');
    const menuDropdown = document.getElementById('user-menu-dropdown');

    menuButton.addEventListener('click', () => {
        menuDropdown.classList.toggle('hidden');
    });

    // Opcional: Cerrar el menú al hacer clic fuera
    document.addEventListener('click', (event) => {
        if (!menuButton.contains(event.target) && !menuDropdown.contains(event.target)) {
            menuDropdown.classList.add('hidden');
        }
    });
});
