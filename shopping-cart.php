<?php

session_start();

// $mysqli = new mysqli("hostname", "username", "password", "database");
$mysqli = new mysqli("localhost", "root", "", "test");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
// Print host information
echo "Connection Successfully. Host info: " . $mysqli->host_info;

$sql = "select * from products";
$result = ($mysqli->query($sql));
// declare array to store the data of database
$row = [];

if ($result->num_rows > 0) {
    //fetch all data from db into array
    $row = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Shopping Cart | Fakemark </title>
    <style> <?php include 'styles.css'; ?> </style>
    <script src="https://kit.fontawesome.com/c36a3b1500.js" crossorigin="anonymous"></script>
</head> 

<body>
    <header>
    <a href="index.php"> <h2> F A K E M A R K </h2> </a>
    <p> <i> Logo </i>     
    <!-- <a href="shopping-cart.php"> -->
    <i class="fa-solid fa-cart-shopping"> </i> </a>
 </p>
    </header> 
    <nav>
        <h2> Shopping Cart </h2>
    </nav>

    <article class="info-container">
        <div class="product-header">
            <h5 class="product-title"> Product </h5>
            <h5 class="price"> Price </h5>
            <h5 class="quantity"> Quantity </h5>
            <h5 class="total"> Total </h5>
        </div>
        
        <div class="products">
        </div>
    </article>


</body>
<script>

    // get add to cart buttons
    let carts = document.querySelectorAll('.addCart');
    let myCart = []
    // const modal = document.querySelector('#myModal');
    // const closeButton = document.querySelector('.close');

    for (let i=0; i < carts.length; i++) {
        carts[i].addEventListener('click', (e) => {
            console.log(e.target.previousElementSibling)
            if (e.target.className === "addCart") {
            // console.log(e.target.previousElementSibling.firstElementChild.textContent);
            // console.log(e.target.previousElementSibling.lastElementChild.textContent);
            const name = e.target.previousElementSibling.firstElementChild.textContent;
            let price = e.target.previousElementSibling.lastElementChild.value;
            console.log(name, price)
            price = parseInt(price)
            const cartElement = {name: name, price: price, inCart: 0}
            console.log(cartElement);
            myCart.push(cartElement);
            console.log(myCart);

            cartNumbers(cartElement);
            totalCost(price);
            }
        })
    }

    function onLoadCartNumbers() {
        let productNumbers = localStorage.getItem('cartNumbers');
        
        if(productNumbers) {
            document.querySelector('.cart-span').textContent = productNumbers;
        }
    }

    // How many items user is adding to the cart
    function cartNumbers(cartElement) {
        let productNumbers = localStorage.getItem('cartNumbers');
        // console.log(productNumbers);
        // console.log(typeof productNumbers);
        
        productNumbers = parseInt(productNumbers);
        // console.log(typeof productNumbers);
        if(productNumbers) {
            localStorage.setItem('cartNumbers', productNumbers + 1);
            document.querySelector('.cart-span').textContent = productNumbers + 1;
        } else {
            localStorage.setItem('cartNumbers', 1)
            document.querySelector('.cart-span').textContent = 1;
        }
        setItems(cartElement)
    }

    function setItems(cartElement) {
        console.log("My product is", cartElement);
        let cartItems = localStorage.getItem("productsInCart");
        console.log("My cart items are", cartItems)
        cartItems = JSON.parse(cartItems);

        if(cartItems != null) {
            if(cartItems[cartElement.name] == undefined) {
                cartItems = {
                    ...cartItems,
                    [cartElement.name]: cartElement
                }
            }
            cartItems[cartElement.name].inCart += 1;
        } else {
        cartElement.inCart = 1
        cartItems = {
            [cartElement.name]: cartElement
            }
        }

        localStorage.setItem("productsInCart", JSON.stringify(cartItems));
    }

    function totalCost (price) {
        // console.log("the product price is", price);
        let cartCost = localStorage.getItem('totalCost');
        // console.log("My cart cost is", cartCost)
        // console.log(typeof cartCost)

        if(cartCost != null) {
            cartCost = parseInt(cartCost);
            localStorage.setItem("totalCost", cartCost + price);
        } else {
            localStorage.setItem("totalCost", price);
        }
    }

    onLoadCartNumbers();

    function displayCart() {
        let itemsInCart = localStorage.getItem("productsInCart")
        itemsInCart = JSON.parse(itemsInCart)
        const containerText = document.querySelector('.info-container');
        let cartCost = localStorage.getItem('totalCost');

        // console.log(itemsInCart)
        if(itemsInCart) {
            containerText.innerHTML = '';
            Object.values(itemsInCart).map(item => {

                containerText.innerHTML += `
                <div class="product">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span> ${item.name} </span>
                </div>
                <div class="price"> £${item.price},00 </div>
                <div class="quantity">
                <i class="fa-solid fa-circle-arrow-left" id="decrease"></i>
                <span> ${item.inCart} </span>
                <i class="fa-solid fa-circle-arrow-right" id="increase"></i>
                </div>
                <div class="total">
                    £${item.inCart * item.price},00
                </div>
                `
            });

            containerText.innerHTML += `
            <div class="basketTotalContainer">
                <h4 class="basketTotalContainer"> Basket Total </h4>
                <h4 class="basketTotal"> 
                £${cartCost},00
                </h4>
            </div>
            `;
        }
   }
   displayCart();
    const cartIcon = document.querySelector('#icon-cart').addEventListener('click', (e) => {

    modal.style.display = "block"; //display modal


    closeButton.addEventListener('click', function(eventClose) { //hide modal
        modal.style.display = "none";
    })

    window.onclick = function(event) { // hide modal
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // for(let i=0; i < myCart.length; i++) {
    // containerText.innerHTML +=  `
    // <div>
    // <ul>
    // <li> ${myCart[i].name} ${myCart[i].price} </li>
    // </ul>
    // </div>
    // `
    // }

})

// const myCart = [];
// const modal = document.querySelector('#myModal');
// const closeButton = document.querySelector('.close');

// document.querySelector(".product-display").addEventListener('click', (e)  => {

//     if (e.target.className === "clothing") {
//         // console.log("wenas")
         
//     console.log(e.target)
//     const name = e.target.parentNode.lastElementChild.firstElementChild.textContent;
//     const price = e.target.parentNode.lastElementChild.lastElementChild.textContent;
 
//     const cartElement = {name: name, price: price}
//     console.log(cartElement);

//     myCart.push(cartElement);
//     console.log(myCart);
// }
// })

// const containerText = document.querySelector('.info-container');
// const cartIcon = document.querySelector('#icon-cart').addEventListener('click', (e) => {
    
//     modal.style.display = "block"; //display modal
    
//     closeButton.addEventListener('click', function(eventClose) { //hide modal
//         modal.style.display = "none";
//     })

//     window.onclick = function(event) { // hide modal
//         if (event.target == modal) {
//             modal.style.display = "none";
//         }
//     }

//     for(let i=0; i < myCart.length; i++) {
//     containerText.innerHTML +=  `
//     <div>
//     <ul>
//     <li> ${myCart[i].name} ${myCart[i].price} </li>
//     </ul>
//     </div>
//     `
//     }
//})

</script>

</html>

<?php
    mysqli_close($mysqli);
    ?>