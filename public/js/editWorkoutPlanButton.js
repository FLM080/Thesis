function submitFormOnClick() {
    const buttons = document.querySelectorAll('[data-form-id]');

    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const formId = this.getAttribute('data-form-id');
            document.getElementById(formId).submit();
        });
    });
}


submitFormOnClick();