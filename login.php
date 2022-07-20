<?php
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    // $user_name = $_POST['user_name'];
    $user_mail = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($user_mail) && !empty($password)) {
        //read from database
        $query = "select * from users where email = '$user_mail' limit 1";

        $result = mysqli_query($mysqlicon, $query);
        
        if($result) {
            if($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        echo "Wrong username or password";
    
    } else {
        echo "Wrong username or password";
    }
}

?>

<html>
<head>
    <title> Login </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">

    <style> <?php include 'log.css'; ?> </style>
</head>

<body>
    <header>
        <a href="index.php"><h2 id='title'> F A K E M A R K E T </h2></a>
    </header>
    
    <main> 
    <section id="img-holder">
    </section>

    <div id="login-box"> 
        <form method="post">
            <h2> Login </h2>
            <label for="email"> Email: </label> <br/>
            <input type="text" name="email" placeholder="janedoe@mail.com" required> <br/>
            <label for="password"> Password: </label> <br/>
            <input type="password" name="password" required> <br/>

            <input type="submit" value="Login"> <br/>

            <p> Do not have an account? Click <a href="signup.php"> here </a> to sign up </p>
        </form>
    </div>
    </main>

    <footer>
        <p><i> developed by japvdev </i></p>
    </footer>
</body>
</html>