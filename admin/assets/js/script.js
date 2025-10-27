const formAdmin = document.getElementById("form-admin");
const usuario = document.getElementById("usuario");
const senha = document.getElementById("senha");

formAdmin.addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }   
});

function validateForm() {
    let valid = true;
    clearErrors();

    if (usuario.value.trim() === '' && senha.value.trim() === '') {
        showError(usuario, 'O Usuário é obrigatório.');
        showError(senha, "A senha é obrigatória");
        valid = false;
    }               

    return valid;       
}           

function showError(input, message) {       
    const errorDiv = document.createElement('div');       
    errorDiv.className = 'error-message';       
    errorDiv.innerText = message;       
    input.parentNode.appendChild(errorDiv);       
}

function clearErrors() {       
    const errorMessages = document.querySelectorAll('.error-message');       
    errorMessages.forEach(function(msg) {       
        msg.remove();       
    });       
}
