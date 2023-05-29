<?php include './includes/core.php'; ?>
<?php
// ******************************************************  CANCEL APPOINTMENT
if(isset($_GET['id'])){
    $appointment_id = $_GET['id'];


    $sql = "UPDATE appointments SET status='approved' WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $appointment_id);

    if($stmt->execute()){
        header("Location: ./appointments.php?status=approved");
        $stmt->close();
        $conn->close();

        exit();

    }else{
        header("Location: ./appointments.php?error=error_approving");
        exit();
    }

    
} else{
    header("Location: ./appointments.php");
    exit();
}
?>