<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Edit Appointment"; ?>

<?php
// *************************  EDIT APPOINTMENT 

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){// retrieves the values from the submitted form data using the $_POST superglobal array. It assigns the values to variables, such as $services, $date, $time, $amount, and $appointment_id.

    $services = implode(", ",$_POST['service']);//this function combines the values of the 'services' field into a comma-separated string
    $date = test_input($_POST['date']);
    $time = test_input($_POST['time']);
    $amount = test_input($_POST['amount']);
    $appointment_id = test_input($_POST['appointment_id']);

    
// preparing an SQL statement using the $dbconn->prepare() method
    $stmt = $dbconn->prepare("UPDATE appointments SET services=?, date=?, time=?, amount=? WHERE id=?");//update query that updates the 'appointments' table with the new values provided
    $stmt->bind_param("ssssi", $services, $date, $time, $amount, $appointment_id);//a method to bind the variables to the prepared statement

    if($stmt->execute()){//executing the prepared statement, if successful; redirection to appoitnments.php page
        header("Location: ./appointments.php?status=appointment_updated");
        $stmt->close();
        $conn->close();
        exit();//function that terminats script if a redirection occures to ensure no further code is executed
    }else{
        header("Location: ./edit_appointment.php?id=$appointment_id&error=error_updating_appointment");
        exit();//function that terminats script if a redirection occures to ensure no further code is executed
    }
}
// ******************************************************  END APPOINTMENT
?>

<?php 
//Do not allow non logged in users
if((!isset($_SESSION['userType']))){
    header('Location: ./login.php?error=log_in');
    exit();
}
?>

<?php
//checking if the 'id' parameter is set in the GET request 
if(!isset($_GET['id'])){
    // if not set, then redirects to appointments.php with an error msg
    header('Location: ./appointments.php?error=select_appointment');
    exit();
}else{// if the 'id' parameter is set, it assigns the value to the $appointment_id variable.
    $appointment_id = $_GET['id'];

//preparing an SQL statement to select the appointment data from the database.
    $sql = "SELECT * FROM appointments WHERE id=?"; 
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);// binding the value of the 'id' to the prepared statement.
    $stmt->execute();//executing the prepared statement
    $result = $stmt->get_result();//obtaining the result

    if(mysqli_num_rows($result)>0){//If the result contains one or more rows 
        while($row = mysqli_fetch_assoc($result)){//the code enters a while loop to fetch each row 
            //the relevant appointment data is extracted and assigned to variables $id, $services, $date, $time, $totalAmount, and $status.
            $id = $row['id'];
            $services = explode(", ", $row['services']);
            $date = $row['date'];
            $time = $row['time'];
            $totalAmount = $row['amount'];
            $status = $row['status'];            
        }

    }else{//if results has no rows, it means there is no appointment with the provided 'id'; redirection with error msg
        header('Location: ./appointments.php?error=no_edit_appointment');
        exit();
    }

}

?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php include './views/edit_appointment.view.php'; ?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        