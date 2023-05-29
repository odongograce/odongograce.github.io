<?php include './includes/core.php'; ?>
<?php
// ******************************************************  CANCEL APPOINTMENT
if(isset($_GET['id'])){//checking if id parameter is set to GET request, Otherwise, it redirects the user to the "appointments.php" page and exits the script.
    $appointment_id = $_GET['id'];//assigning value to  the appointment_id variable


    $sql = "UPDATE appointments SET status='cancelled' WHERE id=?";//an SQL statement to update the 'appointments' table and set the 'status' column to 'cancelled' for the specified 'id'
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('i', $appointment_id);//binding the value of the 'id' to the prepared statement

    if($stmt->execute()){//executing the prepared statement
        header("Location: ./appointments.php?status=cancelled");//if successful, redirection
        $stmt->close();//closing the statement and connection before terminatingthe script
        $conn->close();

        exit();

    }else{//if exceution fails, redirection with msg
        header("Location: ./appointments.php?error=error_cancelling");
        exit();
    }

    
} else{
    header("Location: ./appointments.php");
    exit();
}
?>