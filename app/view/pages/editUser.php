<?php
require APPROOT . '/view/head/head.php';
?>
<main class="container align-self-center ">    
    <h1 class="row col-sm-6">Noted!</h1>
    <p class="row col-sm-6 align-self-center">Here can you change you personal information.</p>
    <form class="col-sm-6 align-self-center" action="<?php echo URLROOT ?>/LoginController/login" method="POST">
        <label class="row " for="inputUser">User: </label>
        <input class="row " type="text" name="userName" id="inputUser">
        <label class="row " for="inputPassword">Password: </label>
        <input class="row " type="password" name="userPassword" id="inputPassword">
        <button class="row " type="submit" value="submit">Login</button>
        <span class="error " ><?php echo $infoData['errorMess'] ?></span>
        
    </form>
</main>