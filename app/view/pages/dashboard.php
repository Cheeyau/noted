<?php
    require APPROOT . '/view/head/head.php';
    require APPROOT . '/view/head/nav.php';
    ?>
    <h1>Good to see you back, <?php echo $_SESSION["userName"] ?>!</h1>
    <p>
        <?php 
        $dt = new DateTime();
        echo $dt->format('Y-m-d H:i:s');
        ?>
    </p>