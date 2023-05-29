<?php include './includes/core.php'; ?>
<?php $page_title = "Dashboard"; ?>
<?php $page = "home"; ?>
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
<?php include './views/index.view.php'; ?>
<?php include './views/footer.view.php'; ?>