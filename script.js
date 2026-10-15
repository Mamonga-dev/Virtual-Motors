
// ==============================
// MENU MOBILE
// ==============================

const menuButton = document.getElementById("menuButton");
const mainNav = document.getElementById("mainNav");
const themeToggle = document.getElementById("themeToggle");
const pageHeader = document.querySelector(".header");

let previousScrollY = window.scrollY;
let accumulatedScrollDelta = 0;

window.addEventListener("scroll", () => {
    if (!pageHeader) return;

    const currentScrollY = window.scrollY;
    accumulatedScrollDelta += currentScrollY - previousScrollY;
    previousScrollY = currentScrollY;

    if (currentScrollY <= pageHeader.offsetHeight) {
        pageHeader.classList.remove("header-hidden");
        accumulatedScrollDelta = 0;
        return;
    }

    if (mainNav?.classList.contains("active")) {
        pageHeader.classList.remove("header-hidden");
        accumulatedScrollDelta = 0;
        return;
    }

    if (accumulatedScrollDelta >= 8) {
        pageHeader.classList.add("header-hidden");
        accumulatedScrollDelta = 0;
    } else if (accumulatedScrollDelta <= -8) {
        pageHeader.classList.remove("header-hidden");
        accumulatedScrollDelta = 0;
    }
}, { passive: true });

function applyTheme(theme) {
    document.documentElement.dataset.theme = theme;
    if (!themeToggle) return;

    const nextTheme = theme === "dark" ? "claro" : "escuro";
    themeToggle.textContent = theme === "dark" ? "☀" : "☾";
    themeToggle.setAttribute("aria-label", `Ativar modo ${nextTheme}`);
    themeToggle.title = `Ativar modo ${nextTheme}`;
}

let savedTheme = null;
try {
    const storedTheme = window.localStorage.getItem("vm-theme");
    if (storedTheme === "light" || storedTheme === "dark") {
        savedTheme = storedTheme;
    }
} catch (error) {
    console.error("Não foi possível ler a preferência de tema salva.", error);
}

const colorSchemePreference = window.matchMedia("(prefers-color-scheme: dark)");
applyTheme(savedTheme || (colorSchemePreference.matches ? "dark" : "light"));

colorSchemePreference.addEventListener("change", (event) => {
    if (savedTheme === null) {
        applyTheme(event.matches ? "dark" : "light");
    }
});

themeToggle?.addEventListener("click", () => {
    savedTheme = document.documentElement.dataset.theme === "dark" ? "light" : "dark";
    applyTheme(savedTheme);
    try {
        window.localStorage.setItem("vm-theme", savedTheme);
    } catch (error) {
        console.error("Não foi possível salvar a preferência de tema.", error);
    }
});

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

    const image = document.createElement("div");
    image.className = "vehicle-image vehicle-image-placeholder";

    const badge = document.createElement("span");
    badge.className = "vehicle-badge";
    badge.textContent = "Disponível";

    const placeholder = document.createElement("span");
    placeholder.className = "vehicle-placeholder";
    placeholder.setAttribute("aria-hidden", "true");
    placeholder.textContent = "🚘";

    image.append(badge, placeholder);

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

    const addToCart = document.createElement("form");
    addToCart.className = "add-to-cart";
    addToCart.method = "post";
    addToCart.action = "./src/carrinho.php";

    const action = document.createElement("input");
    action.type = "hidden";
    action.name = "acao";
    action.value = "adicionar";

    const vehicleId = document.createElement("input");
    vehicleId.type = "hidden";
    vehicleId.name = "id_carro";
    vehicleId.value = vehicle.id_carro;

    const addButton = document.createElement("button");
    addButton.className = "vehicle-arrow";
    addButton.type = "submit";
    addButton.title = "Adicionar ao carrinho";
    addButton.setAttribute("aria-label", `Adicionar ${vehicle.nome} ao carrinho`);
    const cartIcon = document.createElement("img");
    cartIcon.className = "cart-icon";
    cartIcon.src = "./assets/cart-icon.png";
    cartIcon.alt = "";
    cartIcon.setAttribute("aria-hidden", "true");
    addButton.append(cartIcon);

    addToCart.append(action, vehicleId, addButton);
    footer.append(price, addToCart);
    info.append(origin, name, description, footer);
    card.append(image, info);

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

if (searchForm) {
    searchForm.addEventListener("submit", (event) => {
        event.preventDefault();
        loadVehicles();
    });

    loadVehicles();
}
