<?php
session_start();

    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        //something was posted
        $user_name = $_POST['user_name'];
        $user_mail = $_POST['email'];
        $password = $_POST['password'];

        // if(!check_password($password)) {
        //     echo "<script> alert('Invalid password');</script>";
        // }

        if(!check_email($user_mail)) {
            echo "<script> alert('Invalid email address');</script>";
        } else if(!check_password($password)) {
            echo "<script> alert('Invalid password. Must be more than 5 characters and include at least (1) capital letter, (1) number');</script>";    
        }
        else if (!empty($user_name) && !empty($user_mail) && !empty($password)) {
                //save to database
                $user_id = random_num(5);
                $query = "insert into users (user_id,user_name,email,password) values ('$user_id','$user_name','$user_mail','$password')";
    
                mysqli_query($mysqlicon, $query);
                header('Location: login.php');
                die;
            } else {
                echo "Please enter valid information";
            }
        };
?>

<html>
<head>
    <title> Sign Up </title>    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">

    <style> <?php include 'sign.css'; ?> </style>
</head>
<body>
    <header>
        <a href="index.php"><h2 id='title'> F A K E M A R K E T </h2></a>
    </header>

    <main> 

    <div id="signup-box"> 
        <form method="post">
            <h2> Sign Up </h2>
            <label for="name"> Name: </label> <br/>
            <input type="text" name="user_name" required placeholder="Jane Doe"> <br/>
            <label for="email"> Email: </label> <br/>
            <input type="text" name="email" required placeholder="janedoe@mail.com"> <br/>
            <label for="password"> Password: </label> <br/>
            <input type="password" name="password" required> <br/>

            <input type="submit" value="Sign Up"> <br/>

            <p> Already have an account? Click <a href="login.php"> here </a> to Login </p>
        </form>
    </div>

    <section id="pic-holder">
    </section>

    </main>

<footer>
    <p><i> developed by japvdev </i></p>
</footer>

</body>
</html>