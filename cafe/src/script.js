const cartBtn = document.getElementById("cart-btn")
const cartModal = document.getElementById("cart-modal")
const cartItems = document.getElementById("cart-items")
const cartTotal = document.getElementById("cart-total")
const cartCounter = document.getElementById("cart-count")
const checkoutBtn = document.getElementById("checkout-btn")
const closeBtn = document.getElementById("close-modal")

cartBtn.addEventListener("click", function(){
    cartModal.style.display = "flex"
})

// fechar

