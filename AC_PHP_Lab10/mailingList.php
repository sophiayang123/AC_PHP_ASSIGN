<?php
    require_once('header.php');
    require_once('./dao/UserinfoDAO.php');
    require_once('./model/Admininfo.php');

    session_start();
    session_regenerate_id(false);

    function printDB($userinfoDAO){
        $users = $userinfoDAO->getUsers();
        if($users){
            echo '<table border=\'1\'>';
            echo '<tr>
                    <th>Customer Name</th>
                    <th>Phone number</th>
                    <th>Email address</th>
                    <th>referrer</th>
                </tr>';

            foreach($users as $user){
                echo '</tr>';
                echo '<td>' . $user->getcustomerName() . '</td>';
                echo '<td>' . $user->getphoneNumber() . '</td>';
                echo '<td>' . $user->getemailAddress() . '</td>';
                echo '<td>' . $user->getreferrer() . '</td>';
                echo '</tr>';
            }
        
        }
    }

    if(isset($_SESSION['user'])){
        if($_SESSION['user']->isAuthenticated()){
            session_write_close();
             $userinfoDAO = new UserinfoDAO();
             echo 'Session AdminID = ' . $_SESSION['user']->getAdminID() . '</br>';
             echo 'Last login date = ' . $_SESSION['user']->getLastLogin();
             printDB($userinfoDAO);
         }
    }else{
        header('Location: userlogin.php');
    }

?>

    <a href="logout.php">Logout!</a>


<?php require_once('footer.php'); ?>
