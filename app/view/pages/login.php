<?php
require APPROOT . '/view/head/head.php';
 
// Define variables and initialize with empty values
$userErr = $passwordErr = "";
$user = $password = "";

?>

<body class="container">
    <main class="row">    
        <h1>Noted!</h1>
        <p>Please fill in the credential to log in.</p>
        <form class="row" action="<?php  URLROOT . '/site/view/pages/dashboard'?>" method="post">
            <p>
                <label class="col-sm-3" for="inputUser">User: </label>
                <input type="text" name="user" id="inputUser" value="<?php echo $user; ?>">
                <span class="error"><?php echo $userErr; ?></span>
            </p>
            <p >
                <label class="col-sm-3" for="inputPassword">Password: </label>
                <input type="password" name="subject" id="inputPassword value="<?php echo $password; ?>">
            </p>
            <input class="col-sm-3" type="submit" value="Login">
        </form>
    </main>
</body>