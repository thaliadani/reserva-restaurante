const form = document.getElementById('reservaForm');
const nome = document.getElementById('nome_cliente');       
const email = document.getElementById('email_cliente');
const telefone = document.getElementById('telefone_cliente');
const dataReserva = document.getElementById('data_reserva');
const horaReserva = document.getElementById('hora_reserva');
const numPessoas = document.getElementById('num_pessoas');

form.addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }   
});

function validateForm() {
    let valid = true;
    clearErrors();

    if (nome.value.trim() === '') {
        showError(nome, 'O nome é obrigatório.');
        valid = false;
    }               
    if (email.value.trim() === '') {            
        showError(email, 'O email é obrigatório.');            
        valid = false;
    }           
    if (telefone.value.trim() === '') {     
        showError(telefone, 'O telefone é obrigatório.');            
        valid = false;
    }   
    if (dataReserva.value === '') {     
        showError(dataReserva, 'A data da reserva é obrigatória.');             
        valid = false;      
    }   
    if (horaReserva.value === '') {         
        showError(horaReserva, 'A hora da reserva é obrigatória.');             
        valid = false;      
    }           
    if (numPessoas.value === '' || isNaN(numPessoas.value) || parseInt(numPessoas.value) <= 0) {    
        showError(numPessoas, 'O número de pessoas deve ser um valor válido.');             
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

horaReserva.addEventListener('input', function(){
    horaLimite(horaReserva)
})

function formatPhoneNumber(input) {
    // Remove todos os caracteres que não são dígitos
    let phoneNumber = input.value.replace(/\D/g, '');

    // Aplica a máscara dinamicamente
    if (phoneNumber.length > 10) {
        // Formato para celular com 9º dígito: (XX) XXXXX-XXXX
        phoneNumber = phoneNumber.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (phoneNumber.length > 5) {
        // Formato para telefone fixo ou celular sem 9º dígito (em digitação): (XX) XXXX-XXXX
        phoneNumber = phoneNumber.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (phoneNumber.length > 2) {
        // Formato apenas com DDD: (XX) XXXX
        phoneNumber = phoneNumber.replace(/^(\d{2})(\d{0,5}).*/, '($1) $2');
    }
    input.value = phoneNumber;
}

telefone.addEventListener('input', function() {       
    formatPhoneNumber(telefone);       
});

horaReserva.addEventListener('input', function(event) {
    const minHora = '19:00';
    const maxHora = '00:00';
    const inputHora = event.target.value;

    if (inputHora && (inputHora < minHora || inputHora > maxHora)) {
      alert('O horário deve estar entre 19:00 e 00:00.');
      event.target.value = '';
    }
  });