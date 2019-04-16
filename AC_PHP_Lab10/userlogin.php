<?php
    require_once('./dao/UserinfoDAO.php'); 
    require_once('header.php');

    $missingFields = false;
    if(isset($_POST['submit'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            if($_POST['username'] == "" || $_POST['password'] == ""){
                $missingFields = true;
            } else {
                $user = new UserinfoDAO();
                if(!$user->hasDbError()){
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $user->authenticate($username, $password);           
                    if($user->isAuthenticated()){
                        echo 'userlogin user isAuthenticated<br>';
                        //insert date to database at this point
                        $user->updateDate($username,$password);
                        session_start();
                        session_regenerate_id(false); 
                        if(isset($_SESSION['user'])){
                            echo 'userlogin session isset <br>';
                            $_SESSION['user'] = $user;
                            // header('Location: mailqingList.php');
                        }  
                    }
                }
            }
        }
    }
?>

        <!-- MESSAGES -->
        <?php
            if($missingFields){
               echo '<h3 style="color:red;">Please enter both a username and a password</h3>';
           } 
            if(isset($user)){
                if(!$user->isAuthenticated()){
                    echo '<h3 stype="color:red;">Login failed. Please try again.</h3>';
                }
           }
        ?>

        <form name="login" id="login" method="post" action=<?php echo $_SERVER['PHP_SELF'];?> >
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" id="username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="password"></td>
                </tr> 
                <tr>
                    <td><input type="submit" name="submit" id="submit" value="Log in"></td>
                </tr>
            </table>
            <?php echo '<p>Session ID: '. session_id() . '</p>';?>
        </form>

<?php require_once('footer.php'); ?>