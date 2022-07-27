<?php
echo "Wepa";

// start session
session_start();
    $_SESSION;
    
// $mysqli = new mysqli("hostname", "username", "password", "database");
// $mysqli = new mysqli("localhost", "root", "", "test");
$mysqli = new mysqli("eu-cdbr-west-03.cleardb.net", "b21d46832d533e", "8f35cee4", "heroku_b2764aba82c3a92");
 
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
    // fetch all data from db into array
    $row = $result->fetch_all(MYSQLI_ASSOC);
}

// // Login & Signup
// // https://www.youtube.com/watch?v=WYufSGgaCZ8
include("connection.php");
include("functions.php");

$user_data = check_login($mysqlicon);
?> 

<!DOCTYPE html>
<html>
<head>
    <title> Fakemark </title>
    <!-- <link rel="icon" href="../Shopping-icon_30277.ico" type="image/ico"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">
    <!-- welcome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style> <?php include 'css/styles.css'; ?> </style>
    <script src="https://kit.fontawesome.com/c36a3b1500.js" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="scrippt.js"> </script> -->
</head>

<body>
    <header>
    <a href="index.php"><h2 id='title'> F A K E M A R K E T </h2></a>
    <div class="icons">
    <a href="login.php"><i id="user-btn" class="fa-solid fa-user"></i> </a>
    <a href="logout.php" <?php if ($user_data == null){ echo 'style="display:none;"'; } ?>> Log out </a>
    <!-- <p> <i> Logo </i>  -->
    <!-- <button id="sign-up"> Sign Up </button>
    <button id="login"> LOGIN </button>    <br/> -->
    <!-- <a href="shopping-cart.php"> -->
    <i class="fa-solid fa-cart-shopping" id="icon-cart"> </i><span class="cart-span">0</span>
</div>
    </header> 
    <p class="salute" <?php if ($user_data == null){ echo 'style="display:none;"'; } ?>> Welcome back <?php echo $user_data['user_name']; ?>! </p>
    <nav>
        <a id="cat-women" href=""> WOMEN </a>
        <a id="cat-men" href=""> MEN </a>
        <a id="cat-kids" href=""> KIDS </a>
        <a id="cat-baby" href=""> BABY </a>
    </nav>
    <section id="back-img">
        <div class="topLeft"> 
        What better place to buy than in Fakemarket?
        </div>
        </section>
    <section id="myModal" class="modal">
        <section class="modal-details"> 
        <div class="products-container">
        <h3> Shopping Cart </h3>
            <span class="close">&times;</span>
            <div class="product-header">
                <h5 class="product-title"> PRODUCT </h5>
                <h5 class="price"> PRICE </h5>
                <h5 class="quantity"> QUANTITY </h5>
                <h5 class="total"> TOTAL </h5>
                </div>

            <article class="info-container">
            </article>
        </div>
        </section>
        
    </section>
    <p id="subtitle"> Our Products </p>
    <section class="product-display"> 
        <?php
        if(!empty($row))
        foreach($row as $rows)
        { 
        ?>
        <figure id="<?php echo $rows['id'];?>" class="<?php echo $rows['category']; ?>">
        <img class="clothing" title="<?php echo $rows['tag'];?>" src="<?php echo $rows['img'];?>"/>
        <div class="data">
        <figcaption class="name"> <?php echo $rows['name'];?> </figcaption>
        <!-- <figcaption class="price"> £<?php echo $rows['price'];?> </figcaption> -->
        £<input type="number" class="price-input" value="<?php echo $rows['price'];?>" readonly disabled> 
        </div>
        <button class="addCart"> Add to Cart </button>
        
    </figure>
    <?php } 
        ?>
    </section>
    <footer>
        <p><i> developed by japvdev </i></p>
    </footer>

</body>
<script src="https://www.paypal.com/sdk/js?client-id=test&currency=GBP"></script>
<script src="http://js.stripe.com/v3/"> </script>
<script>
    // get add to cart buttons
    let carts = document.querySelectorAll('.addCart');
    let myCart = []
    const modal = document.querySelector('#myModal');
    const closeButton = document.querySelector('.close');

    for (let i=0; i < carts.length; i++) {
        carts[i].addEventListener('click', (e) => {
            console.log(e.target.previousElementSibling)
            // console.log(e.target.parentElement.img)
            if (e.target.className === "addCart") {
            // console.log(e.target.previousElementSibling.firstElementChild.textContent);
            // console.log(e.target.previousElementSibling.lastElementChild.textContent);
            const name = e.target.previousElementSibling.firstElementChild.textContent;
            let price = e.target.previousElementSibling.lastElementChild.value;
            let image = e.target.parentElement.firstElementChild.src;
            let tag = e.target.parentElement.firstElementChild.title;
            console.log("hello" + name, price, tag)
            console.log(typeof price);
            price = parseInt(price)
            console.log(typeof price);
            const cartElement = {id: i+1, image: image, name: name, tag: tag, price: price, inCart: 0}
            console.log(cartElement);
            myCart.push(cartElement);
            console.log(myCart);

            cartNumbers(cartElement);
            totalCost(price);
            }
        })
    }

    //Add number to cart icon
    function onLoadCartNumbers() {
        let productNumbers = localStorage.getItem('cartNumbers');
        if(productNumbers) {
            document.querySelector('.cart-span').textContent = productNumbers;
        }
    }

    // How many items user is adding to the cart
    function cartNumbers(cartElement) {
        console.log("The product clicked is", cartElement)
        let productNumbers = localStorage.getItem('cartNumbers');
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

    // Get details of items in the cart
    function setItems(cartElement) {
        // console.log("My product is", cartElement);
        let cartItems = localStorage.getItem("productsInCart");
        // console.log("My cart items are", cartItems)
        cartItems = JSON.parse(cartItems);

        if(cartItems != null) {
            if(cartItems[cartElement.tag] == undefined) {
                cartItems = {
                    ...cartItems,
                    [cartElement.tag]: cartElement
                }
            }
            cartItems[cartElement.tag].inCart += 1;
        } else {
        cartElement.inCart = 1
        cartItems = {
            [cartElement.tag]: cartElement
            }
        }

        localStorage.setItem("productsInCart", JSON.stringify(cartItems));
    }

    function totalCost (price) {
        // console.log("the product price is", price);
        let cartCost = localStorage.getItem('totalCost');

        if(cartCost != null) {
            cartCost = parseInt(cartCost);
            localStorage.setItem("totalCost", cartCost + price);
        } else {
            localStorage.setItem("totalCost", price);
        }
    }

    onLoadCartNumbers();

    function removeItem(id) {
        let itemsInCart = localStorage.getItem("productsInCart")
        itemsInCart = JSON.parse(itemsInCart)
        
        for (let i=0; i < itemsInCart.length; i += 1) {
            if (itemsInCart[i].id === id) {
                itemsInCart.splice(i, 1)
                return alert(`SuCCESSFUL`) 
                // localStorage.setItem("productsInCart", itemsInCart);
            } else { alert("failed")}
        }
    } 

    function displayCart() {
        let itemsInCart = localStorage.getItem("productsInCart")
        itemsInCart = JSON.parse(itemsInCart)
        const containerText = document.querySelector('.info-container');
        let cartCost = localStorage.getItem('totalCost');

        console.log(itemsInCart)
        if(itemsInCart) {
            containerText.innerHTML = '';
            Object.values(itemsInCart).map(item => {
                // console.log(item)

                containerText.innerHTML += `
                <div class="product">
                    <span class="borrar"><i class="fa-solid fa-circle-xmark" id="${item.id}"></i></span>
                    <img src="${item.image}" id=${item.id} />
                    <span> ${item.name} </span>
                </div>
                
                <div class="price"> £${item.price},00 </div>
                <div class="quantity">
                <span> ${item.inCart} </span>
                </div>
                <div class="total">
                    £${item.inCart * item.price},00
                </div>
                `
            })
            containerText.innerHTML += `
            <div class="basketTotalContainer">
                <h4 class="basketTotalTitle"> Basket Total: </h4>
                <h4 class="basketTotal"> 
                £${cartCost},00
                </h4>
            </div> <br/>
            <div id="paypal-button-container"></div>
            `;
        }
   }
   
    const cartIcon = document.querySelector('#icon-cart').addEventListener('click', (e) => {
    modal.style.display = "block"; //display modal
    displayCart();
    // get delete icons    
    let deleteButton = document.querySelectorAll('.borrar')
    console.log(deleteButton)
    let deleteBtns = [...deleteButton]
    console.log(deleteBtns)
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // let itemsInCart = localStorage.getItem("productsInCart")
            // itemsInCart = JSON.parse(itemsInCart)
            
            let btnId = btn.lastElementChild.id;
            console.log(`You clicked me to delete item ${btnId}`);
            removeItem(btnId)
            // console.log(itemsInCart.denimjacket)
            // if(itemsInCart.denimjacket.id == btnId) {
            //     console.log("Hello");
            //     localStorage.removeItem(itemsInCart, "denimjacket");
            // }
            // if(itemsInCart.denimjacket.id === btnId) {
            //     console.log("hello")
            //     // localStorage.removeItem(itemsInCart.denimjacket.tag)
            // }
            // console.log(btnId);
            // Object.values(itemsInCart).map(item => {
                // console.log(item)
                // console.log(item.id)
                // if (item.id == btnId) {
                    // console.log("Buenas")
                //     localStorage.removeItem(item.tag)
            //    }
                // console.log(btnId)
                // if(item.id == btnId) {
                //     console.log("Matchin")
                //     localStorage.removeItem(item.id)
                // }
            // })
            
            })
            // localStorage.removeItem(name);
    })

    closeButton.addEventListener('click', function(eventClose) { //hide modal
        modal.style.display = "none";
    })

    window.onclick = function(event) { // hide modal
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    //PAYMENT GATEWAY
    // Render the PayPal button into #paypal-button-container
    let cartCost = localStorage.getItem('totalCost');
    paypal.Buttons({
            style: {
                layout: 'horizontal',
                height: 55
            },
            createOrder: function(data,actions) {
                return actions.order.create({
                    purchase_units: [{
                        reference_id: "PUHF",
                        // custom_id: id,
                        amount: {
                            currency_code: "GBP",
                            value: cartCost
                        }
                    }]
                })
            },
            onApprove: function(data,actions) {
                return actions.order.capture().then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id);
                    localStorage.clear();
                })
            }
        }).render('#paypal-button-container');
    })
 
    //FILTER CATEGORIES
const womenBtn = document.querySelector('#cat-women');
const products = document.querySelector('.product-display').children; // console.log(products);
const allProducts = [...products];
const picHolder = document.querySelector('#back-img');
const subtitle = document.querySelector('#subtitle');
// console.log(allProducts);

womenBtn.addEventListener('click', (event) => {
    event.preventDefault();
    picHolder.style.display = 'none';
    subtitle.style.display = 'none';
    // console.log(allProducts[0].className)
    for(let i=0; i <allProducts.length; i++) {
        console.log(allProducts[i].className)
        if(allProducts[i].className === 'men') {
            allProducts[i].style.display = 'none';
        } 
        else if(allProducts[i].className === 'kids'){
            allProducts[i].style.display = 'none';
        } 
        else if (allProducts[i].className === 'baby'){
            allProducts[i].style.display = 'none';
        }
    if(allProducts[i].className === 'women'){
        allProducts[i].style.display = 'block';
    }
}
})

const menBtn = document.querySelector('#cat-men').addEventListener('click', (e) => {
    e.preventDefault();
    picHolder.style.display = 'none';
    subtitle.style.display = 'none';
    for(let i=0; i <allProducts.length; i++) {
        if(allProducts[i].className === 'women') {
            allProducts[i].style.display = 'none';
        } 
        else if(allProducts[i].className === 'kids'){
            allProducts[i].style.display = 'none';
        } 
        else if (allProducts[i].className === 'baby'){
            allProducts[i].style.display = 'none';
        }
    if(allProducts[i].className === 'men'){
        allProducts[i].style.display = 'block';
    }
}
})

const kidsBtn = document.querySelector('#cat-kids').addEventListener('click', (e) => {
    e.preventDefault();
    picHolder.style.display = 'none';
    subtitle.style.display = 'none';
    for(let i=0; i <allProducts.length; i++) {
        if(allProducts[i].className === 'women') {
            allProducts[i].style.display = 'none';
        } 
        else if(allProducts[i].className === 'men'){
            allProducts[i].style.display = 'none';
        } 
        else if (allProducts[i].className === 'baby'){
            allProducts[i].style.display = 'none';
        }
    if(allProducts[i].className === 'kids'){
        allProducts[i].style.display = 'block';
    }
}
})
const babyBtn = document.querySelector('#cat-baby').addEventListener('click', (e) => {
    e.preventDefault();
    picHolder.style.display = 'none';
    subtitle.style.display = 'none';
    for(let i=0; i <allProducts.length; i++) {
        if(allProducts[i].className === 'women') {
            allProducts[i].style.display = 'none';
        } 
        else if(allProducts[i].className === 'men'){
            allProducts[i].style.display = 'none';
        } 
        else if (allProducts[i].className === 'kids'){
            allProducts[i].style.display = 'none';
        }
    if(allProducts[i].className === 'baby'){
        allProducts[i].style.display = 'block';
    }
}
})
</script>
</html>

<?php
    mysqli_close($mysqli);
    ?>