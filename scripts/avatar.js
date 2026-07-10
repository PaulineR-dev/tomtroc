document.addEventListener('DOMContentLoaded', () => {

    const editBtn = document.querySelector('.profil-edit');
    const avatarInput = document.querySelector('#avatar-input');
    const avatarImg = document.querySelector('.profil-photo');

    if (!editBtn || !avatarInput || !avatarImg) return;

    // Ouvre le sélecteur
    editBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Empêche le lien de recharger la page
        avatarInput.click();
    });

    // Envoi AJAX
    avatarInput.addEventListener('change', () => {

        if (avatarInput.files.length === 0) return;

        const formData = new FormData();
        formData.append('avatar', avatarInput.files[0]);

        fetch('index.php?action=uploadAvatar', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Mise à jour de l’image
                avatarImg.src = data.avatar + '?v=' + Date.now();
            }
        })
        .catch(err => console.error(err));
    });
});
