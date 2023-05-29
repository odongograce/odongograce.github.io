<?php include './includes/core.php'; ?>
<?php
// ******************************************************  DELETE USER
if(isset($_GET['id'])){
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $user_id);

    if($stmt->execute()){
        $stmt->close();
        //Alter table to ensure 0 based indexing
        $sql_altTable = "ALTER TABLE users AUTO_INCREMENT = 1";
        $run_sql_altTable = mysqli_query($dbconn, $sql_altTable);

        header("Location: ./users.php?status=user_deleted");
        exit();
        

    }else{
        header("Location: ./users.php?error=delete_user_error");
        exit();
    }
}
?>