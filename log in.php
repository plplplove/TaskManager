<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/logo_icon.png">
    <title>UpNextt</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles/banner_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/log in_style.css">
    <script defer src="scripts/log in_script.js"></script>
</head>
<body>
    <header class="log-in-header">
        <img src="img/logo.png" alt="logo" class="logo">
        <nav class="log-in-navbar">
            <a href="banner.php"><i class="fa-solid fa-house" id="button-home"></i></a>
            <a href="#"><i class="fa-solid fa-globe" id="button-language"></i></a>
        </nav>
    </header>
    <div class="main-body"> 
<div class="main-form">  	
    <input type="checkbox" id="chk" aria-hidden="true">
        <div class="sign-up" id="SignUp">
            <form method="post" action="register.php">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="user" placeholder="User name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button name="SignUp">Sign up</button>
            </form>
        </div>

        <div class="log-in" id="LogIn">
            <form method="post" action="register.php">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button name="LogIn">Login</button>
            </form>
        </div>
</div>
</div> 
</body>
</html>