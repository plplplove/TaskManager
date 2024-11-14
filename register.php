<?php 

include 'connect.php';

if(isset($_POST['SignUp'])){
    $userName=$_POST['user'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $checkEmail="SELECT * FROM users WHERE email='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO users(username, email, password)
                        VALUES ('$userName', '$email', '$password')";
        if($conn->query($insertQuery) === TRUE) {
            session_start();
            $_SESSION['email'] = $email; 
            header("Location: user home.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}


if(isset($_POST['LogIn'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $password=md5($password) ;
   
   $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
   $result=$conn->query($sql);
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: user home.php");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }

}
?>