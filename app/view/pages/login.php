<?php
    require APPROOT . '/view/head/head.php';
    require_once APPROOT . '/view/head/captchaHead.php';
    require APPROOT . '/view/head/nav.php';
?>
<main class="container align-self-center ">    
    <p class="row col-sm-6 align-self-center">Please fill in the credential to log in.</p>
    <form class="col-sm-6 align-self-center" action="<?php echo URLROOT ?>/LoginController/login" method="POST">
        <label class="row " for="inputUser">User: </label>
        <input class="row " type="text" name="userName" id="inputUser">
        <label class="row " for="inputPassword">Password: </label>
        <input class="row " type="password" name="userPassword" id="inputPassword">
        <button class="row " type="submit" value="submit">Login</button>
        <span class="error " ><?php echo $data['errorMess'] ?></span>
        
        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
    </form>
    <button type="button">
        <a href="<?php echo URLROOT ?>/LoginController/registerUserPage">Don't have an account? Create one here!</a>
    </button>
    <button type="button">
        <a href="<?php echo URLROOT ?>/LoginController/resetPasswordPage">Forgot your password? Reset it here!</a>
        
    </button>
</main>