<?php
// start session
session_start();

if(empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

array_push($_SESSION['cart'], $_GET['id']);


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
    <a href="shopping-cart.php"><i class="fa-solid fa-cart-shopping"> </i> </a>
 </p>
    </header> 
    <nav>
        <a href=""> Women </a>
        <a href=""> Men </a>
        <a href=""> Kids </a>
        <a href=""> Baby </a>
    </nav>

    <section id="myModal" class="modal">
        <section class="modal-details"> 
            <span class="close">&times;</span>
            <article class="info-container">
                <label> Size: </label>
                <select name="sizes" id="sizes"> 
                    <option value="XXS"> XXS </option>
                    <option value="XS"> XS </option>
                    <option value="S"> S </option>
                    <option value="M"> M </option>
                    <option value="L"> L </option>
                    <option value="XL"> XL </option>
                    <option value="XXL"> XXL </option>
                </select> <br/>
                <button id="addCart"> Add to Cart </button>
            </article>
        </section>
    </section>

    <section class="img-display"> 
        <?php
        if(!empty($row))
        foreach($row as $rows)
        { 
        ?>
        <figure>
        <img id="<?php echo $rows['id'];?>" class="clothing" src="<?php echo $rows['img'];?>" width="350" height="auto"/>
        <figcaption> <?php echo $rows['name'];?> </figcaption>
        <figcaption>£ <?php echo $rows['price'];?> </figcaption>
        <!-- <button> More </button> -->
        </figure>
        <?php } 
    ?>
        </section>

    <?php 
    function php_func() 
    { echo "Stay Safe"; }
    ?>
    
</body>

<script>

let clothing = document.getElementsByClassName("clothing");
let clothingPics = [...clothing]
console.log(clothingPics);

clothingPics.forEach(pictureInPage => {
    console.log("wenas")
    const modal = document.querySelector('#myModal');
    const closeButton = document.querySelector('.close');

    function clickMe() {
        var result ="<?php php_func();?>"
        document.write(result);
    }


    pictureInPage.addEventListener('click', function(event) {
        console.log("You clicked me nia")
        console.log(pictureInPage.id)

        modal.style.display = "block";
        
        closeButton.addEventListener('click', function(eventClose) {
            modal.style.display = "none";
        })

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    })
})

let addCart = document.getElementById("addCart");
console.log(addCart);
addCart.addEventListener('click', function(e) {
    console.log("Buenas tardes");
    // alert("Item added");
})

</script>

</html>

<?php
    mysqli_close($mysqli);
    ?>