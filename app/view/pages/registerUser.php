<?php
    require APPROOT . '/view/head/head.php';
    require APPROOT . '/view/head/captchaHead.php';
    require APPROOT . '/view/head/nav.php';
?>

<main class="container align-self-center ">    
    <p class="row col-sm-6 align-self-center">Please fill in the credential to register.</p>
    <form id="registerUser" class="row col-sm-6 align-self-center" action="<?php echo URLROOT ?>/LoginController/registerUser" method="POST">
        <label class="row " for="inputUser">User name: </label>
        <input class="row " type="text" name="userName" id="inputUser">
        
        <label class="row " for="inputMail">Email: </label>
        <input class="row " type="text" name="userEmail" id="inputPassword">
        
        <label class="row " for="inputPassword">Password: </label>
        <input class="row " type="password" name="userPassword" id="inputPassword">

        <span class="error " ><?php echo $data["errorMess"] ?></span>
        <button class="row " type="submit" value="submit">Register</button>
        
        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
    </form>    
</main>