const btn = document.querySelector("button"),
      alert = document.querySelector(".alert");


// onde vou receber a mensagem da notificação (aqui posso colocar o dom para pegar a classe da notificação que está recebendo do php)
const msg = "Teste do alert!!!";
const mensagem = document.createElement("div");


function ativar(msg){
    mensagem.classList.add("mensagem");
    mensagem.innerText = msg;
    alert.appendChild(mensagem);

// esse aqui é para a caixa fechar sozinha
    setTimeout(() =>{
        mensagem.style.display = "none";
    }, 4000);
}


// dando um evendo para o meu botão
btn.addEventListener("click", () => { 
    ativar(msg)
});

////////////////////////////////////////////////////////////////////////////////////
const toastSS = document.querySelector(".toast"), // aqui coloca a var php
    closeIcon = document.querySelector(".ph-x"),
    button = document.querySelector("button");

    // aqui é para add uma caixa da notificação
    // ver outro evento em vez do click
button.addEventListener("click", () => {
    toastSS.classList.add(aviso);

    setTimeout(() =>{
        aviso.style.display = "none";
    }, 4000);
});

closeIcon.addEventListener("click", () => {
    toastSS.classList.remove(aviso);
});




closeIcon.addEventListener("click", () => {

});

// NOTIFICAÇÃO SISTEMA CKC
// const btn = document.querySelector("button");
// const notificacao = document.querySelector(".container-feedback");


// function ativarNotific(msg){
//     mensagem.classList.add("mensagem");
//     mensagem.innerText = msg;
//     notificacao.appendChild(mensagem);

//     setTimeout(() =>{
//         mensagem.style.display = "none";
//     }, 4000);
// }

// function ativarError(msg){
//     mensagem.classList.add("mensagem");
//     mensagem.innerText = msg;
//     alert.appendChild(mensagem);
//     notificacao.appendChild(mensagem);

//     setTimeout(() =>{
//         mensagem.style.display = "none";
//     }, 4000);
// }

// btn.addEventListener("click", () => {
//     ativarNotific()
// });