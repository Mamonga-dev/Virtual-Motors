
// ==============================
// MENU MOBILE
// ==============================

const menuButton = document.getElementById("menuButton");
const mainNav = document.getElementById("mainNav");

menuButton.addEventListener("click", () => {
    mainNav.classList.toggle("active");
});


// Fecha o menu depois de clicar em um link

const navLinks = document.querySelectorAll(".nav a");

navLinks.forEach((link) => {

    link.addEventListener("click", () => {
        mainNav.classList.remove("active");
    });

});


// ==============================
// FORMULÁRIO DE BUSCA
// ==============================

const searchForm = document.getElementById("searchForm");

searchForm.addEventListener("submit", (event) => {

    event.preventDefault();

    const vehicleType =
        document.getElementById("vehicleType").value;

    const brand =
        document.getElementById("brand").value;

    const price =
        document.getElementById("price").value;


    console.log({
        vehicleType,
        brand,
        price
    });


    alert(
        "Busca realizada! Em breve os resultados serão exibidos."
    );

});
