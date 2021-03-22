<nav>
    <ul>
        <li><a href="<?php echo URLROOT ?>/pages/home">Home</a></li>
        <li><a href="<?php echo URLROOT ?>/pages/notes">Notes</a></li> 
        <?php
        if (isset($_SESSION['userId'])) {
            if ($_SESSION[$userId] == 1 || $_SESSION[$userId] == 2) {
                echo "<li>";
                echo "<a href=" .  URLROOT . '/pages/users'. ">Users";
                echo "</a>";
                echo "</li>";
            }
        }
        echo "<form action=" . URLROOT . "/site/service/login method='POST' >";
        echo '<li type="submit" name="submit">log out</li>';
        echo "</form>";      
        ?>
    </ul>
</nav>