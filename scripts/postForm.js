const form = document.querySelector('form.post-form');
const button = document.querySelector('button#submit');


button.addEventListener('click', (event) => {
    event.preventDefault();
    const title = document.querySelector('input#title').value.trim();
    const content = document.querySelector('#content').value.trim();
    const image = document.querySelector('input#image').value.trim();
    
    const title_err = document.querySelector('span#title_validation');
    const content_err = document.querySelector('span#content_validation');
    const image_err = document.querySelector('span#image_validation');

    if (title.length < 3 || title.length > 255) {
        title_err.classList.add('title_err','validation_err');
    } else {
        title_err.classList.remove('title_err','validation_err');
    }
    if (content.length < 20 || content.length > 5000) {
        content_err.classList.add('content_err','validation_err');
    } else{
        content_err.classList.remove('content_err','validation_err');
    }
    if (image.length < 6 || image.length > 255) {
        image_err.classList.add('image_err','validation_err');
    } else{
        image_err.classList.remove('image_err','validation_err');
    }

    if ((title.length >= 3 && title.length <= 255) && (content.length >= 20 && content.length <= 5000) && (image.length >= 6 && image.length <= 255)) {
        form.submit();
    }
});