<?php include './includes/core.php'; ?>
<?php $page_title = "Add Service"; ?>
<?php $page = "services"; ?>

<?php
// ******************************************************  SEND MESSAGE
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $serviceName = test_input($_POST['serviceName']);
        $serviceAmount = test_input($_POST['serviceAmount']);
        $description = test_input($_POST['description']);

        //insert message
        $stmt = $dbconn->prepare("INSERT INTO services (service_name, service_description, amount) VALUES (?,?,?)");
        $stmt->bind_param("ssi",$serviceName, $description, $serviceAmount);

        if($stmt->execute()){          
            header('Location: ./services.php?status=service_added');
        } else{
            header('Location: ./add_service.php?error=error_adding_service');        
        }    
        $stmt->close();
        $conn->close();
        exit();

    }
?>

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
<?php include './views/aside-nav.view.php'; ?>
<?php include './views/add_service.view.php'; ?>
<?php include './views/footer.view.php'; ?>