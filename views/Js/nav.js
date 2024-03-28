const hamburger = document.querySelector(".hamburger") ;
const nav = document.querySelector(".nav");
const drop_down = document.querySelector(".drop-down"); 
const dropdown_toggle = document.querySelector(".dropdown-toggle");

/*quando o user clicar a nav terá a classe 'active' e se ele clicar de novo a classe será removida */
hamburger.addEventListener("click", () => nav.classList.toggle("active"));/*com o toggle quer dizer > adiciona caso tenha e remova caso tenha*/

/* Quando o usuário clicar no item "Corridas", alterne a classe "active" na dropdown-menu */
dropdown_toggle.addEventListener("click", () => drop_down.classList.toggle("active"));