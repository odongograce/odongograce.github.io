<?php include './includes/core.php'; ?>
<?php $page_title = "Edit Service"; ?>
<?php $page = "services"; ?>
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
// ******************************************************  EDIT service
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $serviceName = test_input($_POST['serviceName']);
    $serviceAmount = test_input($_POST['serviceAmount']);
    $description = test_input($_POST['description']);
    $service_id = test_input($_POST['service_id']);

    

    $stmt = $dbconn->prepare("UPDATE services SET service_name=?, service_description=?, amount=? WHERE id=?");
    $stmt->bind_param("ssii", $serviceName, $description, $serviceAmount, $service_id);

    if($stmt->execute()){
        header("Location: ./services.php?status=service_edited");
        $stmt->close();
        $conn->close();
        exit();
    }else{
        header("Location: ./edit_service.php?id=$service_id&error=error_editing_service");
        exit();
    }
}
?>


<?php
if(!isset($_GET['id'])){
    // You cant access this page if there is no animal selected to be edited
    header('Location: ./services.php?error=select_service');
    exit();
}else{
    $service_id = $_GET['id'];

    $sql = "SELECT * FROM services WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $service_name = $row['service_name'];
            $service_description = $row['service_description'];
            $amount = $row['amount'];
}

    }else{
        header('Location: ./services.php?error=no_edit_service');
        exit();
    }

}
?>
<?php include './views/aside-nav.view.php'; ?>
<?php include './views/edit_service.view.php'; ?>
<?php include './views/footer.view.php'; ?>