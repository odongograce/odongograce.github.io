<?php include './includes/core.php'; ?>
<?php $page_title = "Messages"; ?>
<?php $page = "messages"; ?>
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

    if($page_category == "read"){
        include './views/messages.view.read.php';
    }

    if($page_category == "unread"){
        include './views/messages.view.unread.php';
    }

}else{
    include './views/messages.view.php';
}
?>
<?php include './views/footer.view.php'; ?>