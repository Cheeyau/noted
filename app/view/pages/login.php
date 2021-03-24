<?php
require APPROOT . '/view/head/head.php';
?>
<main class="container align-self-center ">    
    <h1 class="row col-sm-6">Noted!</h1>
    <p class="row col-sm-6 align-self-center">Please fill in the credential to log in.</p>
    <form class="col-sm-6 align-self-center" action="<?php echo URLROOT ?>/pages/login" method="POST">
        <label class="row " for="inputUser">User: </label>
        <input class="row " type="text" name="userName" id="inputUser">
        <label class="row " for="inputPassword">Password: </label>
        <input class="row " type="password" name="userPassword" id="inputPassword">
        <input class="row " type="submit" value="Login">
        <span class="row error " ><?php echo $infoData['errorMess'] ; ?></span>
        <button type="button">
            <a href="<?php echo URLROOT ?>/pages/resetPassword">Don't have an account? Create one here!</a>
        </button>
        <button type="button">
            <a href="<?php echo URLROOT ?>/pages/registerUser">Forgot your password? Reset it here!</a>
        </button>
    </form>
</main>