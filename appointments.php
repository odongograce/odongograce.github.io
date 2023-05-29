<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Your Appointments"; ?>

<?php
//checks if the 'userType' session variable is not set hence Does not allow non logged in users
if((!isset($_SESSION['userType']))){
    header('Location: ./login.php?error=log_in');
    exit();
}
?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php
if(isset($_GET['category'])){//checking if the 'category' parameter is set in the GET request. If the parameter is set, it proceeds with the execution. Otherwise, it falls into the else block.

    $page_category = $_GET['category'];//assigning the value to the $page_category variable if parameter is set

    if($page_category == "approved"){//checking the value using the multiple if statements
        include './views/appointments.approved.view.php';
    }

    if($page_category == "pending"){
        include './views/appointments.pending.view.php';
    }

    if($page_category == "cancelled"){
        include './views/appointments.cancelled.view.php';
    }
}else{
    include './views/appointments.view.php';
}

?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        