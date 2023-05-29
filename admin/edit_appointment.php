<?php include './includes/core.php'; ?>
<?php $page_title = "Edit Appointment"; ?>
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
// ******************************************************  EDIT APPOINTMENT
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $services = implode(", ",$_POST['service']);
    $date = test_input($_POST['date']);
    $time = test_input($_POST['time']);
    $amount = test_input($_POST['amount']);
    $appointment_id = test_input($_POST['appointment_id']);

    

    $stmt = $dbconn->prepare("UPDATE appointments SET services=?, date=?, time=?, amount=? WHERE id=?");
    $stmt->bind_param("ssssi", $services, $date, $time, $amount, $appointment_id);

    if($stmt->execute()){
        header("Location: ./appointments.php?status=edited");
        $stmt->close();
        $conn->close();
        exit();
    }else{
        header("Location: ./edit_appointment.php?id=$appointment_id&error=error_updating_appointment");
        exit();
    }
}
?>


<?php
if(!isset($_GET['id'])){
    // You cant access this page if there is no animal selected to be edited
    header('Location: ./appointments.php?error=select_appointment');
    exit();
}else{
    $appointment_id = $_GET['id'];

    $sql = "SELECT * FROM appointments WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
            $services = explode(", ", $row['services']);
            $date = $row['date'];
            $time = $row['time'];
            $amount = $row['amount'];
            $status = $row['status'];            
        }

    }else{
        header('Location: ./appointments.php?error=no_edit_appointment');
        exit();
    }

}
?>
<?php include './views/aside-nav.view.php'; ?>
<?php include './views/edit_appointment.view.php'; ?>
<?php include './views/footer.view.php'; ?>