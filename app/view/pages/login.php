<?php
require APPROOT . '/view/head/head.php';
 
// Define variables and initialize with empty values
$userErr = $passwordErr = "";
$user = $password = "";

?>
<main class="container align-self-center ">    
    <h1 class="row col-sm-6">Noted!</h1>
    <p class="row col-sm-6 align-self-center">Please fill in the credential to log in.</p>
    <form class="col-sm-6 align-self-center" action="<?php echo APPROOT . '/app/view/pages/login.php' ?>" method="POST">
        <label class="row " for="inputUser">User: </label>
        <input class="row " type="text" name="user" id="inputUser" value="<?php echo $user; ?>">
        <label class="row " for="inputPassword">Password: </label>
        <input class="row " type="password" name="password" id="inputPassword value="<?php echo $password; ?>">
        <input class="row " type="submit" value="Login">
        <span class="row " class="error"><?php echo $infoData['errorMess'] ; ?></span>
        <p>
            <a href="<?php echo APPROOT . '/app/view/pages/resgisterUser.php' ?>">Don't have an account? Create one here!</a>
        </p>
        <p>
            <a href="<?php echo APPROOT . '/app/view/pages/resetPassword.php' ?>">Forgot your password? Reset it here!</a>
        </p>
    </form>
</main>