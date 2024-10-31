
document.addEventListener('DOMContentLoaded', function() {
    const inputNom = document.getElementById('client_users_nom');
    const inputPrenom = document.getElementById('client_users_prenom');
    const inputLogin = document.getElementById('client_users_login');
    const inputPassword = document.getElementById('client_users_password');
    const inputUsername = document.getElementById('client_username');
    const inputTelephone = document.getElementById('client_telephone');
    const inputAddress = document.getElementById('client_address');
    const toggleSwitch = document.getElementById('toggleSwitch');
    const formClient = document.getElementById('formClient');
    const formUser = document.getElementById('formUser');
    
    inputNom.removeAttribute('required');
    inputPrenom.removeAttribute('required');
    inputLogin.removeAttribute('required');
    inputPassword.removeAttribute('required');
    inputUsername.removeAttribute('required');
    inputTelephone.removeAttribute('required');
    inputAddress.removeAttribute('required');

    showFormUser(toggleSwitch);
    toggleSwitch.addEventListener('change', function() {
        showFormUser(toggleSwitch);
    });

    function showFormUser(toggleSwitch) {
        if (toggleSwitch.checked) {
            formUser.classList.remove('hidden');
        } else {
            formUser.classList.add('hidden');
        }
    }
});