var formLogar = document.querySelector('#logar')
var formRegistrar = document.querySelector('#registrar')
var btnColor = document.querySelector('.btnColor')



document.querySelector('#btnLogar')
  .addEventListener('click', () => {
    formLogar.style.left = "25px"
    formRegistrar.style.left = "450px"
    btnColor.style.left = "17px"
})

document.querySelector('#btnRegistrar')
  .addEventListener('click', () => {
    formLogar.style.left = "-450px"
    formRegistrar.style.left = "25px"
    btnColor.style.left = "118px"
})

document.querySelector('#produtos')
  .addEventListener('click', () => {
    btnColor.style.left = "118px"
})

document.querySelector('#inicio')
  .addEventListener('click', () => {
    btnColor.style.left = "118px"
})

document.querySelector('#sobre')
  .addEventListener('click', () => {
    btnColor.style.left = "118px"
})

