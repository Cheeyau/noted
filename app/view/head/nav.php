<nav>
    <ul>
        <li><a href="<?php echo URLROOT . '/app/view/pages/home.php' ?>">Home</a></li>
        <li><a href="<?php echo URLROOT . '/app/view/pages/notes.php' ?>">Notes</a></li> 
        <?php
        if (isset($_SESSION['userId'])) {
            if ($_SESSION['userId'] == 1 || $_SESSION['userId'] == 2) {
                echo "<li>";
                echo "<a href=" .  URLROOT . '/pages/users'. ">Users";
                echo "</a>";
                echo "</li>";
            }
        }
        echo '<form action="' . URLROOT . '/app/lib/sessionLogout.php" method="POST">';
        echo '<li type="submit" name="submit">log out</li>';
        echo "</form>";      
        ?>
    </ul>
</nav>