document.addEventListener('DOMContentLoaded', function () {
    const fabMain = document.getElementById('fabMain');
    const fabMenu = document.getElementById('fabMenu');
    const fabIconPlus  = document.getElementById('fabIconPlus');
    const fabIconClose = document.getElementById('fabIconClose');
    
    if (fabMain) {
        fabMain.addEventListener('click', function () {
            const isOpen = fabMenu.classList.toggle('open');
            fabIconPlus.style.display  = isOpen ? 'none'  : 'block';
            fabIconClose.style.display = isOpen ? 'block' : 'none';
        });
    
        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.fab-container')) {
                fabMenu.classList.remove('open');
                fabIconPlus.style.display  = 'block';
                fabIconClose.style.display = 'none';
            }
        });
    
        // Close when a modal opens
        document.querySelectorAll('.fab-menu-item').forEach(item => {
            item.addEventListener('click', function () {
                fabMenu.classList.remove('open');
                fabIconPlus.style.display  = 'block';
                fabIconClose.style.display = 'none';
            });
        });
    }
});
