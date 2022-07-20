<?php
// start session
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
    <title> Fakemark </title>
    <style> <?php include 'styles.css'; ?> </style>
    <script src="https://kit.fontawesome.com/c36a3b1500.js" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="scrippt.js"> </script> -->
</head>

<body>
    <header>
    <h2> F A K E M A R K </h2>
    <p> <i> Logo </i>     
    <!-- <a href="shopping-cart.php"> -->
    <i class="fa-solid fa-cart-shopping" id="icon-cart"> </i><span>0</span>
 </p>
    </header> 
    <nav>
        <a href=""> Women </a>
        <a href=""> Men </a>
        <a href=""> Kids </a>
        <a href=""> Baby </a>
    </nav>
    <!-- <section class="test"> </section> -->
    <section id="myModal" class="modal">
        <section class="modal-details"> 
            <span class="close">&times;</span>
            <article class="info-container">
            <h3> Shopping Cart </h3>
            </article>
        </section>
    </section>

    <section class="img-display"> 
        <?php
        if(!empty($row))
        foreach($row as $rows)
        { 
        ?>
        <figure id="<?php echo $rows['id'];?>">
        <img class="clothing" src="<?php echo $rows['img'];?>" width="350" height="auto"/>
        <div class="data">
        <figcaption class="name"> <?php echo $rows['name'];?> </figcaption>
        <figcaption class="price"> £<?php echo $rows['price'];?> </figcaption>
        
        <label> Size: </label>
        <select name="sizes" id="sizes">
            <option> Select Size </option> 
            <option value="XXS"> XXS </option>
            <option value="XS"> XS </option>
            <option value="S"> S </option>
            <option value="M"> M </option>
            <option value="L"> L </option>
            <option value="XL"> XL </option>
            <option value="XXL"> XXL </option>
        </select> <br/>
        <label for="qty"> Quantity: </label> 
        <input type="number" min="1" max="50"> </input> <br/>
        <button id="addCart"> Add to Cart </button>
        </div>
    </figure>
    <?php } 
        ?>
    </section>
</body>

<script>

const myCart = [];
const modal = document.querySelector('#myModal');
const closeButton = document.querySelector('.close');

document.querySelector(".img-display").addEventListener('click', (e)  => {

    if (e.target.className === "clothing") {
        // console.log("wenas")
         
    console.log(e.target)
    const name = e.target.parentNode.lastElementChild.firstElementChild.textContent;
    const price = e.target.parentNode.lastElementChild.lastElementChild.textContent;
 
    const cartElement = {name: name, price: price}
    console.log(cartElement);

    myCart.push(cartElement);
    console.log(myCart);
}
})

const containerText = document.querySelector('.info-container');
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

    for(let i=0; i < myCart.length; i++) {
    containerText.innerHTML +=  `
    <div>
    <ul>
    <li> ${myCart[i].name} ${myCart[i].price} </li>
    </ul>
    </div>
    `
    }

    // containerText.innerHTML =  `
    // <div>
    // <h3> Shopping Cart </h3>
    // <ul>
    // <li> ${myCart[0].name} ${myCart[0].price} </li>
    // </ul>
    // </div>
    // `
})

// let clothingPics = [...clothing]
// console.log(clothingPics);

// clothingPics.forEach(pictureInPage => {
//     console.log("wenas")
//     const modal = document.querySelector('#myModal');
//     const closeButton = document.querySelector('.close');

//     pictureInPage.addEventListener('click', function(event) {
//         console.log("You clicked me nia")

//         modal.style.display = "block";
        
//         closeButton.addEventListener('click', function(eventClose) {
//             modal.style.display = "none";
//         })

//         window.onclick = function(event) {
//             if (event.target == modal) {
//                 modal.style.display = "none";
//             }
//         }
//     })
// })

// let addCart = document.getElementById("addCart");
// // console.log(addCart);
// addCart.addEventListener('click', function(e) {
//     console.log("Buenas tardes");
//     // alert("Item added");
// })

</script>
</html>

<?php
    mysqli_close($mysqli);
    ?>