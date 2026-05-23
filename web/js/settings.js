document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accent-preset-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.accent-preset-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const hex = this.dataset.hex;
            document.getElementById('accent-input').value = hex;
            applyAccent(hex); // live preview
        });
    });
});