</head>
<nav>
    <ul>
        <?php 
            // check if use login for redirect to login
            if(!isset($_SESSION['userId'])) {
                echo '</li><h1 class="row col-sm-6"><a href="';
                echo URLROOT . '/LoginController/login';
                echo '">Noted!</a></h1></li>';
            }
            // check if use login for redirect to dashboard
            if(isset($_SESSION['userId'])) {
                echo '<li><a href="';
                echo URLROOT . '/IndexController/index';
                echo '">Noted!</a></li>';
                
                echo '<li><a href="';
                echo URLROOT . '/NoteController/index';
                echo '">Notes</a></li>';
                
                // check if use login us admin
                if (isset($_SESSION['userRoll'])) {
                    if ($_SESSION['userRoll'] == 1 || $_SESSION['userRoll'] == 2) {
                        echo '<li><a href="';
                        echo URLROOT . '/UserController/getUserCon'. '">Users';
                        echo "</a></li>";
                    }
                }
                echo '<li><a href="';
                echo URLROOT . '/UserController/editUser">';
                echo $_SESSION['userName'].'</a></li>';

                // logout button
                echo "<li><form action=";
                echo URLROOT . '/LoginController/logout method="POST">';
                echo '<button type="submit" name="submit">Log out</button></form></li>';
            }
        ?> 
    </ul>
</nav>