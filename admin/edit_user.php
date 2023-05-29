<?php include './includes/core.php'; ?>
<?php $page_title = "Edit User"; ?>
<?php $page = "users"; ?>
<?php 
//Do not allow non logged in users
if((!isset($_SESSION['userType']))){
    header('Location: ../login.php?error=user');
    exit();
}
if($_SESSION['userType']!== 'admin'){
    header('Location: ../login.php?error=user');
    exit();
}
?>

<?php
// ******************************************************  EDIT ACCOUNT
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $first_name = test_input($_POST['firstName']);
    $last_name = test_input($_POST['lastName']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $phone = test_input($_POST['phone']);
    $user_id = test_input($_POST['user_id']);


    if(!empty($password)){      

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $dbconn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, user_password=? WHERE id=?");
        $stmt->bind_param("sssssi",$first_name, $last_name, $email, $phone, $hashed_password, $user_id);

        if($stmt->execute()){        
            
            header('Location: ./users.php?status=account_edited');
            $stmt->close();
            $conn->close();
            exit();
        }else{
            header('Location: ./users.php?error=error_editing_account');
            exit();
        }

    }
    

    $stmt = $dbconn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("ssssi",$first_name, $last_name, $email, $phone, $user_id);

    if($stmt->execute()){        
            
        header('Location: ./users.php?status=account_edited');
        $stmt->close();
        $conn->close();
        exit();
    }else{
        header('Location: ./users.php?error=error_editing_account');
        exit();
    }
}
// ******************************************************  END ACCOUNT
?>


<?php
if(!isset($_SESSION['user_id'])){
    header('Location: ./login.php?error=log_in');
    exit();
}else{

    if(!isset($_GET['id'])){
        header('Location: ./users.php?error=select_user');
        exit();    
    }

    $user_id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $firstName = $row['first_name'];
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
<?php include './views/aside-nav.view.php'; ?>
<?php include './views/edit_user.view.php'; ?>
<?php include './views/footer.view.php'; ?>