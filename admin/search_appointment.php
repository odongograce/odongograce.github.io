<?php include './includes/core.php'; ?>
<?php $page_title = "Search Results"; ?>
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


<?php
if(!isset($_SESSION['user_id'])){
    header('Location: ./login.php?error=log_in');
    exit();
}else{

    if(!isset($_GET['search'])){
        header('Location: ./appointments.php?error=search');
        exit();    
    }

}
?>
<?php include './views/aside-nav.view.php'; ?>
<?php include './views/search.appointments.view.php'; ?>
<?php include './views/footer.view.php'; ?>