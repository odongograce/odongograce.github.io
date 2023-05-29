<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Book Appointment"; ?>

<?php
// ******************************************************  ADD APPOINTMENT

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
//this method is a post, it retrieves the value of services,date, time,amount,userid and status from post data. The values are then passed through the test_input function for sanitization.
    $services = implode(", ",$_POST['service']);
    $date = test_input($_POST['date']);
    $time = test_input($_POST['time']);
    $amount = test_input($_POST['amount']);
    $user_id = $_SESSION['user_id'];
    $status = "pending";
    
  //an SQL statement to insert the sanitized values into the 'services' table.
    $stmt = $dbconn->prepare("INSERT INTO appointments (user_id, services, date, time, amount, status) VALUES (?,?,?,?,?,?)");
     //binding the sanitized variables to their placeholders 
    $stmt->bind_param("isssss", $user_id, $services, $date, $time, $amount, $status);
 // executing the insert statement If successful, user is directed to the appointments page.
    if($stmt->execute()){
        header("Location: ./appointments.php?status=appointment_sent");
         //closing the prepared statement and the db connection. 
        $stmt->close();
        $conn->close();
        exit();
    }else{
        header("Location: ./book-appointment.php?error=error_booking_appointment");
        exit();
    }
}
// ******************************************************  END APPOINTMENT
?>

<?php 
//checks to ensure non logged in users are not allowed into the system. Usertype is not set
if((!isset($_SESSION['userType']))){//if user is not logged in, she is direted to the login page
    header('Location: ./login.php?error=log_in');
    exit();
}
?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php include './views/book-appointment.view.php'; ?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        