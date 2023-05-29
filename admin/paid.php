<?php include './includes/core.php'; ?>
<?php
// ******************************************************  PAID APPOINTMENT
if(isset($_GET['id'])){
    $appointment_id = $_GET['id'];


    $sql = "UPDATE appointments SET paid='paid' WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $appointment_id);

    if($stmt->execute()){
        header("Location: ./appointments.php?status=paid");
        $stmt->close();
        $conn->close();

        exit();

    }else{
        header("Location: ./appointments.php?error=error_paid");
        exit();
    }

    
} else{
    header("Location: ./appointments.php");
    exit();
}
?>