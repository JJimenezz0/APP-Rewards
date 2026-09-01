// Inventario de items vintage con imágenes estáticas y fijas
const products = [
    { id: 1, name: "Cámara Vintage Kodak",       price: 85000,  points: 85,  img: "https://divatek.com.co/wp-content/uploads/2025/08/C300R_WEB_01_42f52923-1961-4884-b890-cd953f4a2bd0.png.webp" },
    { id: 2, name: "Tocadiscos Retro",            price: 150000, points: 150, img: "https://media.falabella.com/falabellaCO/122495353_01/public" },
    { id: 3, name: "Máquina de Escribir Clásica", price: 120000, points: 120, img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9oYmcOpTgVJT3SJy8QuGXpT4xbLXlqnKhTmqNLI9-bKvcKUWijglKpYcb&s=10" },
    { id: 4, name: "Radio de Válvulas Antigua",   price: 95000,  points: 95,  img: "https://i.pinimg.com/736x/50/cd/10/50cd10533e1a666cc4f13e5c848a794a.jpg" },
    { id: 5, name: "Reloj de Bolsillo",           price: 60000,  points: 60,  img: "https://www.elcoleccionistaeclectico.com/resources/productos/reloj-bolsillo-zeda-plata-ley-800-cuerda-remontoir-segundero-motivos-florales-suiza-1920-25566.JPG" },
    { id: 6, name: "Chaqueta de Cuero Vintage",   price: 180000, points: 180, img: "https://www.camyr.com/wp-content/uploads/2026/05/Chaqueta-Aviadora-en-Gamuza-de-Cuero-Hombre-Chocolate-H424-CAMYR.png" }
];

const cart = {};

const formatCOP = (val) => "$" + val.toLocaleString("es-CO");

function renderProducts() {
    const grid = document.getElementById("productGrid");
    if (!grid) return;
    grid.innerHTML = products.map(p => `
        <div class="product-card">
            <img src="${p.img}" alt="${p.name}">
            <div class="product-name">${p.name}</div>
            <div class="product-price">${formatCOP(p.price)}</div>
            <div class="product-points">+${p.points} pts al comprar</div>
            <button type="button" onclick="addToCart(${p.id})">Añadir a carrito</button>
        </div>
    `).join("");
}

function addToCart(id) {
    cart[id] = (cart[id] || 0) + 1;
    renderCart();
    toggleCart(true);
}

function removeFromCart(id) {
    delete cart[id];
    renderCart();
}

function renderCart() {
    const itemsContainer = document.getElementById("cartItems");
    if (!itemsContainer) return;

    const entries = Object.entries(cart);
    let totalPrice = 0, totalPoints = 0, totalItems = 0;

    if (entries.length === 0) {
        itemsContainer.innerHTML = '<p class="empty-cart-msg" id="emptyCartMsg">Aún no has añadido items.</p>';
    } else {
        itemsContainer.innerHTML = entries.map(([id, qty]) => {
            const p = products.find(prod => prod.id === parseInt(id));
            totalPrice += p.price * qty;
            totalPoints += p.points * qty;
            totalItems += qty;
            return `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <span>${p.name}</span>
                        <span class="cart-item-qty">x${qty} · ${formatCOP(p.price * qty)}</span>
                    </div>
                    <button type="button" class="cart-item-remove" onclick="removeFromCart(${p.id})">✕</button>
                </div>
            `;
        }).join("");
    }

    document.getElementById("cartTotalPrice").textContent = formatCOP(totalPrice);
    document.getElementById("cartTotalPoints").textContent = totalPoints + " ⭐";
    document.getElementById("cartBadge").textContent = totalItems;
    document.getElementById("cartToggleBtn").classList.toggle("visible", totalItems > 0);
    document.getElementById("cartPayBtn").disabled = totalItems === 0;
}

function toggleCart(open) {
    document.getElementById("cartSidebar").classList.toggle("open", open);
}

function payCart() {
    const entries = Object.entries(cart);
    if (entries.length === 0) return;

    const cartData = entries.map(([id, qty]) => {
        const p = products.find(prod => prod.id === parseInt(id));
        return { id: p.id, name: p.name, price: p.price, points: p.points, qty };
    });

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "dashboard.php";

    const inputAction = document.createElement("input");
    inputAction.type = "hidden";
    inputAction.name = "action";
    inputAction.value = "checkout";
    form.appendChild(inputAction);

    const inputData = document.createElement("input");
    inputData.type = "hidden";
    inputData.name = "cart_items";
    inputData.value = JSON.stringify(cartData);
    form.appendChild(inputData);

    document.body.appendChild(form);
    form.submit();
}

renderProducts();
renderCart();