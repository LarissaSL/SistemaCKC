const hamburger = document.querySelector(".hamburger") ;
const nav = document.querySelector(".nav");

/*quando o user clicar a nav terá a classe 'active' e se ele clicar de novo a classe será removida */
hamburger.addEventListener("click", () => nav.classList.toggle("active"));/*com o toggle quer dizer > adiciona caso tenha e remova caso tenha*/