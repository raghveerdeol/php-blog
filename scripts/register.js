const form = document.querySelector('form.signUp');
const button = document.querySelector('button#submit-button');
const reset = document.querySelector('button#reset');
console.log(button);

const username_err = document.querySelector('span#username_validation');
const password_err = document.querySelector('span#password_validation');
const confirm_password_err = document.querySelector('span#confirm_password_validation');

button.addEventListener('click', (event) => {
    event.preventDefault();
    const username = document.querySelector('input#username').value.trim();
    const password = document.querySelector('input#password').value.trim();
    const confirm_password = document.querySelector('input#confirm_password').value.trim();
    
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
    if (password !== confirm_password) {
        confirm_password_err.classList.add('confirm_password_err','validation_err');
    } else {
        confirm_password_err.classList.remove('confirm_password_err','validation_err');
    }

    if ((username.length >= 3) && (password.length >= 6) && (password === confirm_password)) {
        form.submit();
    }
});

reset.addEventListener('click', (event) => {
        username_err.classList.remove('username_err','validation_err');
        password_err.classList.remove('password_err','validation_err');
        confirm_password_err.classList.remove('confirm_password_err','validation_err');
})