
// ==============================
// MENU MOBILE
// ==============================

const menuButton = document.getElementById("menuButton");
const mainNav = document.getElementById("mainNav");

menuButton?.addEventListener("click", () => {
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
const vehicleSearch = document.getElementById("vehicleSearch");
const priceMax = document.getElementById("priceMax");
const vehicleGrid = document.getElementById("vehicleGrid");
const vehicleStatus = document.getElementById("vehicleStatus");

const currencyFormatter = new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL"
});

function createVehicleCard(vehicle) {
    const card = document.createElement("article");
    card.className = "vehicle-card";

    const info = document.createElement("div");
    info.className = "vehicle-info";

    const origin = document.createElement("span");
    origin.className = "vehicle-year";
    origin.textContent = vehicle.jogo_origem;

    const name = document.createElement("h3");
    name.textContent = vehicle.nome;

    const description = document.createElement("p");
    description.className = "vehicle-description";
    description.textContent = vehicle.cor ? `Cor: ${vehicle.cor}` : "Cor não informada";

    const footer = document.createElement("div");
    footer.className = "vehicle-footer";

    const price = document.createElement("strong");
    price.textContent = currencyFormatter.format(Number(vehicle.preco));

    const contact = document.createElement("a");
    contact.href = "#contato";
    contact.className = "vehicle-arrow";
    contact.setAttribute("aria-label", `Consultar ${vehicle.nome}`);
    contact.textContent = "→";

    footer.append(price, contact);
    info.append(origin, name, description, footer);
    card.append(info);

    return card;
}

async function loadVehicles() {
    vehicleStatus.textContent = "Carregando veículos...";
    vehicleGrid.replaceChildren();

    const parametros = new URLSearchParams();
    if (vehicleSearch.value.trim()) {
        parametros.set("busca", vehicleSearch.value.trim());
    }
    if (priceMax.value) {
        parametros.set("preco_max", priceMax.value);
    }

    try {
        const resposta = await fetch(`./src/pesquisa.php?${parametros.toString()}`);
        const veiculos = await resposta.json();

        if (!resposta.ok) {
            throw new Error(veiculos.erro || "Falha ao carregar os veículos.");
        }

        vehicleGrid.replaceChildren(...veiculos.map(createVehicleCard));
        vehicleStatus.textContent = veiculos.length
            ? `${veiculos.length} veículo(s) encontrado(s).`
            : "Nenhum veículo encontrado para esses filtros.";
    } catch (error) {
        vehicleStatus.textContent = "Não foi possível carregar os veículos. Verifique se o servidor PHP e o banco estão ativos.";
    }
}

searchForm.addEventListener("submit", (event) => {
    event.preventDefault();
    loadVehicles();
});

loadVehicles();
