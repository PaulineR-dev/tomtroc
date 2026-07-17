document.addEventListener('DOMContentLoaded', () => {

    const editLink = document.querySelector('.edit-photo-link');
    const fileInput = document.querySelector('#edit-image-input');
    const image = document.querySelector('.book-cover');

    if (!editLink || !fileInput || !image) return;

    editLink.addEventListener('click', (e) => {
        e.preventDefault();
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length === 0) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            image.src = e.target.result;
        };
        reader.readAsDataURL(fileInput.files[0]);
    });

});
