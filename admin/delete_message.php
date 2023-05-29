<?php include './includes/core.php'; ?>
<?php
// ******************************************************  DELETE MESSAGE
if(isset($_GET['id'])){
    $message_id = $_GET['id'];
    $sql = "DELETE FROM messages WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $message_id);

    if($stmt->execute()){
        $stmt->close();
        //Alter table to ensure 0 based indexing
        $sql_altTable = "ALTER TABLE messages AUTO_INCREMENT = 1";
        $run_sql_altTable = mysqli_query($dbconn, $sql_altTable);

        header("Location: ./messages.php?status=message_deleted");
        exit();
        

    }else{
        header("Location: ./messages.php?error=delete_message_error");
        exit();
    }
}
?>