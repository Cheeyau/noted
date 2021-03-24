<nav>
    <ul>
        <li><a id="home" href="<?php echo URLROOT ?>/pages/dashboard">Home</a></li>
        <li><a id="notes" href="<?php echo URLROOT ?>/pages/note">Notes</a></li> 
        <li><a id="notes" href="<?php echo URLROOT ?>/pages/login">login</a></li> 
        <?php
        if (isset($_SESSION['userId'])) {
            if ($_SESSION['userId'] == 1 || $_SESSION['userId'] == 2) {
                echo "<li>";
                echo "<a href=" .  URLROOT . '/pages/users'. ">Users";
                echo "</a>";
                echo "</li>";
            }
        }
        echo '<form action="' . URLROOT . '/lib/sessionLogout" method="POST">';
        echo '<li type="submit" name="submit">log out</li>';
        echo "</form>";      
        
        ?>
    </ul>
</nav>