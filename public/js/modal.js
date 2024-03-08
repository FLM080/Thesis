document.querySelectorAll('.edit-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        let target = button.getAttribute('data-bs-target');
        let myModal = new bootstrap.Modal(document.querySelector(target), {})
        myModal.show()
    })
})