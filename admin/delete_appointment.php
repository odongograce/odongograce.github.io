<?php include './includes/core.php'; ?>
<?php
// ******************************************************  DELETE MESSAGE
if(isset($_GET['id'])){
    $appointment_id = $_GET['id'];
    $sql = "DELETE FROM appointments WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $appointment_id);

    if($stmt->execute()){
        $stmt->close();
        //Alter table to ensure 0 based indexing
        $sql_altTable = "ALTER TABLE appointments AUTO_INCREMENT = 1";
        $run_sql_altTable = mysqli_query($dbconn, $sql_altTable);

        header("Location: ./appointments.php?status=deleted");
        exit();
        

    }else{
        header("Location: ./appointments.php?error=delete_appointment_error");
        exit();
    }
}
?>