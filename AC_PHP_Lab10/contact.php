<?php 
    $page_title = 'contract';
    require_once('header.php'); 
    require_once('./dao/UserinfoDAO.php');

    try{
        $userinfoDAO = new UserinfoDAO();
        $noError = true;
        if(isset($_POST['btnSubmit'])){
            $customerName = $_POST['customerName'];
            $phoneNumber = $_POST['phoneNumber'];
            $emailAddress = $_POST['emailAddress'];
            $referral = $_POST['referral'];

            if($customerName==='' || !(preg_match('/[A-Za-z]/', $customerName))){
                $error_cn = '<div class="error" >Please enter an valid name</div>';
                $noError = false;
            }
            if($phoneNumber==='' || (preg_match('/[^0-9]/', $phoneNumber))){
                $error_pn = '<div class="error" >Please enter an valid phone number</div>';
                $noError = false;
            }
            if($emailAddress === ''  | !filter_var($emailAddress, FILTER_VALIDATE_EMAIL)){
                $error_ea = '<div class="error" >Please enter an valid email address</div>';
                $noError = false;
            }       
            if(!isset($_POST['referral'])){
                $error_r = '<div class="error" >Please choose a referral</div>';
                $noError = false;
            }

            $query = 'SELECT * FROM mailingList';
            $tablerows = $userinfoDAO->countRows($query);
            if($tablerows>0){  
                $query2 = "SELECT * FROM mailingList WHERE emailAddress = '".$_POST['emailAddress']."'";
                $repeatrows = $userinfoDAO->countRows($query2);
                if ($repeatrows> 0){
                    $error_repeat = '<div class="error" >The email address is already exist</div>';       
                    $noError = false;
                }
            }  



            if($noError==true){
                $emailHash = password_hash($_POST['emailAddress'], PASSWORD_DEFAULT);
                $user = new Userinfo($_POST['customerName'], $_POST['phoneNumber'], $emailHash, $_POST['referral']);
                $addSuccess = $userinfoDAO->addUser($user);
                echo '<h3>' . $addSuccess . '</h3>';

                if(isset($_FILES['fileToUpload'])){
                    $target_dir = "./files/";
                    $file_name = $_FILES['fileToUpload']['name'];
                    $target_store = $target_dir.$file_name;
                    if(file_exists($target_store)) {
                        $error_file = "<div class='error' > file uploaded filed.</div>";
                        //$noError = false;
                    } elseif(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_store) ) {
                        $error_file = '<div>The file '. basename( $_FILES['fileToUpload']['name']). ' has been uploaded.</div>';
                    }else{
                        $error_file = "<div class='error' >Sorry, there was an error uploading your file.</div>";
                        //$noError = false;
                    }
                    
                }

            }

            //     $query3 = "INSERT INTO mailingList (customerName, phoneNumber, emailAddress, referrer) VALUES ";
            //     $query3 .= "('".$_POST['customerName']."', '".$_POST['phoneNumber']."', '".$_POST['emailAddress']."','".$_POST['referral']."')";
            //     $run = mysqli_query($connection, $query3) || die("Bad query $query3");
            // }
        }    
?>

<div id="content" class="clearfix">
    <aside>
            <h2>Mailing Address</h2>
            <h3>1385 Woodroffe Ave<br>
                Ottawa, ON K4C1A4</h3>
            <h2>Phone Number</h2>
            <h3>(613)727-4723</h3>
            <h2>Fax Number</h2>
            <h3>(613)555-1212</h3>
            <h2>Email Address</h2>
            <h3>info@wpeatery.com</h3>
    </aside>
    <div class="main">
        <h1>Sign up for our newsletter</h1>
        <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
        <form name="frmNewsletter" id="frmNewsletter" method="post"  action= "contact.php" enctype="multipart/form-data">
        <!-- action="newsletterSignup.php" -->
            <table>
                <tr>
                    <td>Name:</td>
                    <td>
                        <input type="text" name="customerName" id="customerName" size='40'>
                        <?php if(isset($error_cn)) {echo $error_cn;} ?>
                    </td>
                </tr>

                <tr>
                    <td>Phone Number:</td>
                    <td>
                        <input type="tel" name="phoneNumber" id="phoneNumber" size='40'>
                        <?php if(isset($error_pn)) {echo $error_pn;} ?>
                    </td>
                </tr>
                <tr>
                    <td>Email Address:</td>
                    <td><input type="text" name="emailAddress" id="emailAddress" size='40'>
                    <?php if(isset($error_ea)) {echo $error_ea;} ?>
                </tr>
                <tr>
                    <td>How did you hear<br> about us?</td>
                    <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
                        Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
                        TV<input type='radio' name='referral' id='referralTV' value='TV'>
                        Other<input type='radio' name='referral' id='referralOther' value='other'>
                        <?php if(isset($error_r)) {echo $error_r;} ?>
                        <?php if(isset($error_repeat)) {echo $error_repeat;} ?>
                    </td>
                </tr>
                <tr>
                    <td>Choose a file to upload:<br>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <?php if(isset($error_file)) {echo $error_file;} ?>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                </tr>
            </table>
        </form>
    </div><!-- End Main -->
</div><!-- End Content -->
<?php
    }catch(Exception $e){
        echo '<h3>Error on page.</h3>';
        echo '<p>'. $e->getMessage() . '</p>';
    }
?>
<?php require_once('footer.php'); ?>

