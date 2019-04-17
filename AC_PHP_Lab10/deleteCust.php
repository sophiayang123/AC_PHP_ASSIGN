<?php
   require_once('header.php'); 
   require_once('./dao/UserinfoDAO.php');
   
   session_start();
   session_regenerate_id(false);

   $missingFields = false;
   if(isset($_SESSION['user'])){
        if($_SESSION['user']->isAuthenticated()){
            session_write_close();
            if(isset($_POST['btnSubmit'])){
                if(isset($_POST['deleteCust'])){
                    if($_POST['deleteCust'] == "" ){
                        $missingFields = true;
                    }else{
                        $userinfoDAO = new UserinfoDAO();
                        $customerID = $_POST['deleteCust'];
                        if($userinfoDAO->deleteUser($customerID)){
                            echo '<h3 style="color:red;">deletion successfully</h3>';
                        }else{
                            echo "deletion failed";
                        }
                    }
                }
            }
        }
    }else{
        header('Location: userlogin.php');  
    }

?>
    <?php
        if($missingFields){
            echo '<h3 style="color:red;">Please enter a customer id</h3>';
        } 
    ?>

    <form name="frmNewsletter" id="frmNewsletter" method="post" action= "deleteCust.php" >
        <table>
            <tr>
                <td>Please enter the customer number</td>
                <td><input type="text" name="deleteCust" id="deleteCust" ></td>
            </tr>
            <tr>
                <td><input type='submit' name='btnSubmit' id='btnSubmit' value='submit' ></td> 
            </tr>
        </table>
    </form>
    <?php require_once('footer.php'); ?>