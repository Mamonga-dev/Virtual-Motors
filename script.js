
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

const vehicleImages = [
    { model: "ferrari", src: "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=85" },
    { model: "lamborghini", src: "https://images.unsplash.com/photo-1614200187524-dc4b892acf16?auto=format&fit=crop&w=1200&q=85" },
    { model: "porsche", src: "https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=85" },
    { model: "nissan", src: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=85" },
    { model: "bmw", src: "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=85" },
    { model: "mclaren", src: "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=85" }
];

const sampleVehicles = [
    { id_carro: 1, nome: "Ferrari 488 GTB", cor: "Vermelho", preco: 2500000, jogo_origem: "Forza Horizon" },
    { id_carro: 2, nome: "Lamborghini Huracán", cor: "Amarelo", preco: 3000000, jogo_origem: "Forza Horizon" },
    { id_carro: 3, nome: "Porsche 911", cor: "Preto", preco: 1800000, jogo_origem: "Need for Speed" },
    { id_carro: 4, nome: "Nissan Skyline GT-R", cor: "Azul", preco: 900000, jogo_origem: "Need for Speed" },
    { id_carro: 5, nome: "BMW M4", cor: "Branco", preco: 1200000, jogo_origem: "Forza Horizon" },
    { id_carro: 6, nome: "McLaren 720S", cor: "Laranja", preco: 2800000, jogo_origem: "Forza Horizon" }
];

function getVehicleImage(vehicle) {
    const vehicleName = String(vehicle.nome || "").toLocaleLowerCase("pt-BR");
    const matchingImage = vehicleImages.find(({ model }) => vehicleName.includes(model));

    return matchingImage?.src || vehicleImages[0].src;
}

function filterSampleVehicles() {
    const term = vehicleSearch.value.trim().toLocaleLowerCase("pt-BR");
    const maxPrice = Number(priceMax.value) || Infinity;

    return sampleVehicles.filter((vehicle) => {
        const searchableText = `${vehicle.nome} ${vehicle.cor} ${vehicle.jogo_origem}`
            .toLocaleLowerCase("pt-BR");

        return searchableText.includes(term) && vehicle.preco <= maxPrice;
    });
}

function createVehicleCard(vehicle) {
    const card = document.createElement("article");
    card.className = "vehicle-card";

    const image = document.createElement("div");
    image.className = "vehicle-image";

    const vehicleImage = document.createElement("img");
    vehicleImage.src = getVehicleImage(vehicle);
    vehicleImage.alt = `Foto ilustrativa do veículo ${vehicle.nome}`;
    vehicleImage.loading = "lazy";
    vehicleImage.addEventListener("error", () => {
        vehicleImage.src = "./assets/image.png";
        vehicleImage.alt = `Ilustração de veículo para ${vehicle.nome}`;
    }, { once: true });

    const badge = document.createElement("span");
    badge.className = "vehicle-badge";
    badge.textContent = "Disponível";

    image.append(vehicleImage, badge);

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
    addButton.textContent = "🛒";

    addToCart.append(action, vehicleId, addButton);
    footer.append(price, addToCart);
    info.append(origin, name, description, footer);
    card.append(image, info);

    return card;
}

async function loadVehicles() {
    const sampleCatalog = filterSampleVehicles();
    vehicleGrid.replaceChildren(...sampleCatalog.map(createVehicleCard));
    vehicleStatus.textContent = "Carregando estoque atualizado. Exibindo catálogo de demonstração.";

    const parametros = new URLSearchParams();
    if (vehicleSearch.value.trim()) {
        parametros.set("busca", vehicleSearch.value.trim());
    }
    if (priceMax.value) {
        parametros.set("preco_max", priceMax.value);
    }

    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000);

    try {
        const resposta = await fetch(`./src/pesquisa.php?${parametros.toString()}`, {
            signal: controller.signal
        });
        const veiculos = await resposta.json();

        if (!resposta.ok) {
            throw new Error(veiculos.erro || "Falha ao carregar os veículos.");
        }

        vehicleGrid.replaceChildren(...veiculos.map(createVehicleCard));
        vehicleStatus.textContent = veiculos.length
            ? `${veiculos.length} veículo(s) encontrado(s).`
            : "Nenhum veículo encontrado para esses filtros.";
    } catch (error) {
        const vehicles = filterSampleVehicles();
        vehicleGrid.replaceChildren(...vehicles.map(createVehicleCard));
        vehicleStatus.textContent = `Não foi possível consultar o banco de dados. Exibindo catálogo de demonstração: ${vehicles.length} veículo(s).`;
    } finally {
        clearTimeout(timeoutId);
    }
}

if (searchForm) {
    searchForm.addEventListener("submit", (event) => {
        event.preventDefault();
        loadVehicles();
    });

    loadVehicles();
}

const cepInput = document.getElementById("cep");
const cepButton = document.getElementById("consultCep");
const cepStatus = document.getElementById("cepStatus");

cepInput?.addEventListener("input", () => {
    const digits = cepInput.value.replace(/\D/g, "").slice(0, 8);
    cepInput.value = digits.length > 5
        ? `${digits.slice(0, 5)}-${digits.slice(5)}`
        : digits;
});

cepButton?.addEventListener("click", () => {
    const cep = cepInput.value.replace(/\D/g, "");
    cepStatus.textContent = cep.length === 8
        ? "A consulta automática de CEP será integrada em breve. Preencha o endereço manualmente."
        : "Digite um CEP válido com 8 números. A consulta automática será integrada em breve.";
});

const checkoutResult = document.getElementById("checkoutResult");
const paymentMethodMessage = document.getElementById("paymentMethodMessage");
const reviewCheckoutButton = document.getElementById("reviewCheckout");

reviewCheckoutButton?.addEventListener("click", () => {
    checkoutResult.textContent = "A finalização ainda não está integrada. Nenhum dado ou pagamento foi enviado.";
});

document.querySelectorAll('input[name="paymentMethod"]').forEach((option) => {
    option.addEventListener("change", () => {
        const methodNames = {
            pix: "Pix",
            credit: "Cartão de crédito",
            boleto: "Boleto"
        };
        paymentMethodMessage.textContent = `A opção ${methodNames[option.value]} será disponibilizada quando a integração de pagamento estiver pronta.`;
    });
});
