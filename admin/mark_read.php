<?php include './includes/core.php'; ?>
<?php
// ******************************************************  MARK AS READ
if(isset($_GET['id'])){
    $message_id = $_GET['id'];


    $sql = "UPDATE messages SET status='read' WHERE id=?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $message_id);

    if($stmt->execute()){
        header("Location: ./messages.php?status=read");
        $stmt->close();
        $conn->close();

        exit();

    }else{
        header("Location: ./messages.php?error=error_read");
        exit();
    }

    
} else{
    header("Location: ./messages.php");
    exit();
}
?>