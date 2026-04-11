function toggleInventoryMenu(button) {
    const allMenus = document.querySelectorAll('.inventory-action-menu');
    const currentMenu = button.parentElement.querySelector('.inventory-action-menu');

    allMenus.forEach(menu => {
        if (menu !== currentMenu) {
            menu.classList.add('hidden');
        }
    });

    if (currentMenu) {
        currentMenu.classList.toggle('hidden');
    }
}

function inventoryAction(action) {
    alert(action);
    document.querySelectorAll('.inventory-action-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
}

function resolveInventoryAlert() {
    const target = document.getElementById('supplier-form-section');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        alert('Move to supplier form section');
    }
}

function openHubStatus() {
    alert('Main Hub Status\n\nCapacity: 84%\nDaily Thru: 1.2k');
}

function openSupplierDetail(name) {
    alert('Supplier detail: ' + name);
}

document.addEventListener('click', function (event) {
    if (!event.target.closest('.relative.inline-block')) {
        document.querySelectorAll('.inventory-action-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});