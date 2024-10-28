const form = document.querySelector('form.data-form');
const button = document.querySelector('button.buttons');


button.addEventListener('click', (event) => {
    event.preventDefault();
    const username = document.querySelector('input#username').value.trim();
    const password = document.querySelector('input#password').value.trim();
    const username_err = document.querySelector('span#username_validation');
    const password_err = document.querySelector('span#password_validation');

    if (username.length < 3) {
        username_err.classList.add('username_err','validation_err');
    } else {
        username_err.classList.remove('username_err','validation_err');
    }
    if (password.length < 6) {
        password_err.classList.add('password_err','validation_err');
    } else{
        password_err.classList.remove('password_err','validation_err');
    }

    if ((username.length >= 3) && (password.length >= 6)) {
        form.submit();
    }
});