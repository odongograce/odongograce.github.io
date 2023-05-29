<?php include './includes/core.php'; ?>
<?php $page_title = "Appointments"; ?>
<?php $page = "appointments"; ?>
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

<?php
if(isset($_GET['category'])){
    $page_category = $_GET['category'];

    if($page_category == "pending"){
        include './views/appointments.view.pending.php';
    }

    if($page_category == "cancelled"){
        include './views/appointments.view.cancelled.php';
    }

    if($page_category == "approved"){
        include './views/appointments.view.approved.php';
    }

}else{
    include './views/appointments.view.php';}
?>


<?php include './views/footer.view.php'; ?>