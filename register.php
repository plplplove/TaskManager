<?php
session_start();
require_once 'config.php';
require_once 'connect.php';

function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

if(isset($_POST['SignUp'])){
    $userName = sanitize($_POST['user']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $hashedPassword = md5($password);

    $checkEmail = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        echo "<script>
            alert('This email address is already registered!');
            setTimeout(function() {
                window.history.back();
            }, 100);
        </script>";
        exit();
    } else {
        $insertQuery = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $userName, $email, $hashedPassword);
        
        if($stmt->execute()) {
            $_SESSION['email'] = $email;
            header("Location: user_home.php");
            exit();
        } else {
            echo "<script>
                alert('Registration error: " . $conn->error . "');
                setTimeout(function() {
                    window.history.back();
                }, 100);
            </script>";
            exit();
        }
    }
}

if(isset($_POST['LogIn'])){
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $hashedPassword = md5($password);
    
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashedPassword);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $user['email'];
        header("Location: user_home.php");
        exit();
    } else {
        echo "<script>
            alert('Incorrect Email or Password');
            setTimeout(function() {
                window.history.back();
            }, 100);
        </script>";
        exit();
    }
}
?>