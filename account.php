<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Account"; ?>

<?php
// ******************************  EDIT ACCOUNT
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
   
    $first_name = test_input($_POST['firstName']);
    $last_name = test_input($_POST['lastName']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $phone = test_input($_POST['phone']);
    $user_id = $_SESSION['user_id'];


    if(!empty($password)){ //checking if the variable '$password' is not empty    

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);//if not empty then the psw value should be hashed

        
        // preparing an SQL statement using the $dbconn->prepare() method
        $stmt = $dbconn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, user_password=? WHERE id=?");//update query that updates the 'users' table with the new values provided
        $stmt->bind_param("sssssi",$first_name, $last_name, $email, $phone, $hashed_password, $user_id);//a method to bind the variables to the prepared statement

        if($stmt->execute()){ //executing the prepared statement, if successful; redirection to account.php page       
            
            header('Location: ./account.php?status=account_updated');
            $stmt->close();
            $conn->close();
            exit();
        }else{//if not successful
            header('Location: ./account.php?error=error_editing_account');
            exit();//function that terminats script if a redirection occures to ensure no further code is executed
    }
}
    

    $stmt = $dbconn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("ssssi",$first_name, $last_name, $email, $phone, $user_id);

    if($stmt->execute()){        
            
        header('Location: ./account.php?status=account_updated');
        $stmt->close();
        $conn->close();
        exit();
    }else{
        header('Location: ./account.php?error=error_updating_account');
        exit();
    }
}
// ******************************************************  END ACCOUNT
?>

<?php 
//checks if the 'userType' session variable is not set Does not allow non logged in users
if((!isset($_SESSION['userType']))){
    header('Location: ./login.php?error=log_in');
    exit();
}
?>

<?php
if(!isset($_SESSION['user_id'])){
    // You cant access this page if there is no animal selected to be edited
    header('Location: ./login.php?error=log_in');
    exit();
}else{
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $phone = $row['phone'];
        }

    }else{
        header('Location: ./login.php?error=log_in');
        exit();
    }

}

?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php include './views/account.view.php'; ?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        