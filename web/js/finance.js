document.addEventListener('DOMContentLoaded', function () {

    const editModal = document.getElementById('editAccountModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('edit-account-id').value       = btn.dataset.id;
            document.getElementById('edit-account-name').value     = btn.dataset.name;
            document.getElementById('edit-account-currency').value = btn.dataset.currency;
            document.getElementById('edit-account-type').value = btn.dataset.type;
            document.getElementById('edit-account-balance').value  = btn.dataset.balance;
        });
    }

    const deleteModal = document.getElementById('deleteAccountModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('delete-account-id').value         = btn.dataset.id;
            document.getElementById('delete-account-name').textContent = btn.dataset.name;
        });
    }

});