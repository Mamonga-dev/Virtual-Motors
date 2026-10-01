// ==============================
// MENU MOBILE
// ==============================

const menuButton = document.getElementById("menuButton");
const mainNav = document.getElementById("mainNav");

if (menuButton && mainNav) {
    menuButton.addEventListener("click", () => {
        mainNav.classList.toggle("active");
    });
}

const navLinks = document.querySelectorAll(".nav a");
navLinks.forEach((link) => {
    link.addEventListener("click", () => {
        if (mainNav) {
            mainNav.classList.remove("active");
        }
    });
});

// ==============================
// FORMULÁRIO DE BUSCA
// ==============================

const searchForm = document.getElementById("searchForm");

if (searchForm) {
    searchForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const vehicleType = document.getElementById("vehicleType")?.value || "";
        const brand = document.getElementById("brand")?.value || "";
        const price = document.getElementById("price")?.value || "";

        console.log({ vehicleType, brand, price });
        alert("Busca realizada! Em breve os resultados serão exibidos.");
    });
}