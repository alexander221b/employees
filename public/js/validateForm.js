const form = document.querySelector('#form');
const submitBtn = document.querySelector('#submitBtn');
var submit = true;

form.onsubmit = function() {
    return validateSubmit();
};

const fullname = document.querySelector('#fullname');
const email = document.querySelector('#email');
const sex1 = document.querySelector('#sex1');
const sex2 = document.querySelector('#sex2');
const area = document.querySelector('#area');
const description = document.querySelector('#description');
const notice = document.querySelector('#notice');
const roles = document.querySelectorAll('#roles');

const fullnameInfo = document.querySelector('#fullnameInfo');
const emailInfo = document.querySelector('#emailInfo');
const sexInfo = document.querySelector('#sexInfo');
const areaInfo = document.querySelector('#areaInfo');
const descriptionInfo = document.querySelector('#descriptionInfo');
const noticeInfo = document.querySelector('#noticeInfo');
const rolesInfo = document.querySelector('#rolesInfo');

fullname.addEventListener('input', validateFullname);
email.addEventListener('input', validateEmail);
sex1.addEventListener('click', validateSex);
sex2.addEventListener('click', validateSex);
area.addEventListener('input', validateArea);
description.addEventListener('input', validateDescription);
roles.forEach(rol => {
    rol.addEventListener('click', validateRoles)
  })

function validateFullname(e) {
    var value = e.srcElement.value;
    var numValue = value.length;
    const letters = /^([a-zA-Z\sÁÉÍÓÚáéíóúÑñ]+)$/;
    if(value.match(letters) || value === ""){
        fullnameInfo.innerHTML = "";
        
    }
    else{
        fullnameInfo.classList.add("text-danger"); 
        fullnameInfo.innerHTML = "El nombre sólo puede contener letras.";
        
    }
    if(numValue >= 255){
        fullnameInfo.classList.add("text-danger"); 
        fullnameInfo.innerHTML = "El nombre no puede tener más de 255 caracteres.";
        
    }
}

function validateEmail(e){
    var value = e.srcElement.value;
    const emailFormat = /\S+@\S+\.\S+/;
    var numValue = value.length;
    if(value.match(emailFormat) || value === ""){
        emailInfo.innerHTML = "";
    }else{
        emailInfo.classList.add("text-danger"); 
        emailInfo.innerHTML = "El formato no es correcto.";
    }
    if(numValue >= 255){
        emailInfo.classList.add("text-danger"); 
        emailInfo.innerHTML = "El email no puede tener más de 255 caracteres.";
    }
}

function validateSex(e){
    var value = e.srcElement.value;
    if(value){
        sexInfo.innerHTML = "";
    }
}

function validateArea(e){
    var value = e.srcElement.value;
    if(value){
        areaInfo.innerHTML = "";
    }
}

function validateDescription(e){
    var value = e.srcElement.value;
    if(value){
        descriptionInfo.innerHTML = "";
    }
}

function validateRoles(e){
    var element = e.srcElement;
    if(element.checked){
        rolesInfo.innerHTML = "";
    }
}

function validateSubmit(){
    var validateSubmit = true;
    if(fullname.value == ""){
        fullnameInfo.classList.add("text-danger"); 
        fullnameInfo.innerHTML = "El campo no puede estar vacío.";
        validateSubmit = false;
    }
    if(email.value == ""){
        emailInfo.classList.add("text-danger"); 
        emailInfo.innerHTML = "El campo no puede estar vacío.";
        validateSubmit = false;
    }
    if(sex1.checked === false && sex2.checked === false){
        sexInfo.classList.add("text-danger"); 
        sexInfo.innerHTML = "Debe seleccionar el sexo.";
        validateSubmit = false;
    }
    if(area.value == ""){
        areaInfo.classList.add("text-danger"); 
        areaInfo.innerHTML = "El campo no puede estar vacío.";
        validateSubmit = false; 
    }
    if(description.value == ""){
        descriptionInfo.classList.add("text-danger"); 
        descriptionInfo.innerHTML = "El campo no puede estar vacío.";
        validateSubmit = false;  
    }

    const numSelRol = document.querySelectorAll('#roles:checked').length;

    if(numSelRol == 0){
       rolesInfo.classList.add("text-danger"); 
       rolesInfo.innerHTML = "Debe seleccionar un rol.";
        validateSubmit = false;   
    }
    return validateSubmit;

}

