
const avatar = document.querySelector('img#avatar');
const upload = document.querySelector('button#upload');
const form = document.querySelector('form#form-upload');
const fileInput = document.querySelector('input#fileToUpload');
const image_err = document.querySelector('span#image_validation');



avatar.addEventListener('click', (event) => {
    form.classList.toggle('hidden');
    upload.classList.toggle('hidden');
    fileInput.classList.toggle('hidden');
    image_err.classList.remove('image_err');
});

upload.addEventListener('click', (event) => {
    event.preventDefault();
    let file = fileInput.files[0];

    if (!file) {
        image_err.classList.add('image_err');
    } else {
        image_err.classList.remove('image_err');
        form.submit();
    }
});

