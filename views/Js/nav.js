const hamburger = document.querySelector(".hamburger");
const nav = document.querySelector(".nav");
const dropDowns = document.querySelectorAll(".drop-down");
const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

/*quando o user clicar a nav terá a classe 'active' e se ele clicar de novo a classe será removida */
hamburger.addEventListener("click", () => nav.classList.toggle("active"));/*com o toggle quer dizer > adiciona caso tenha e remova caso tenha*/

/* Quando o usuário clicar no item "Corridas", alterne a classe "active" na dropdown-menu */
dropdownToggles.forEach((toggle, index) => {
    toggle.addEventListener("click", () => {
        dropDowns[index].classList.toggle("active");
        toggle.classList.toggle("active"); // Adiciona ou remove a classe 'active' no dropdown-toggle clicado
    });
});