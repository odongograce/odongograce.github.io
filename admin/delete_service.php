<?php include './includes/core.php'; ?>
<?php
// ******************************************************  DELETE USER
if(isset($_GET['id'])){
    $service_id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $service_id);

    if($stmt->execute()){
        $stmt->close();
        //Alter table to ensure 0 based indexing
        $sql_altTable = "ALTER TABLE services AUTO_INCREMENT = 1";
        $run_sql_altTable = mysqli_query($dbconn, $sql_altTable);

        header("Location: ./services.php?status=service_deleted");
        exit();
        

    }else{
        header("Location: ./services.php?error=delete_service_error");
        exit();
    }
}
?>