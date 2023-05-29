<?php 
$no_of_pending_appointments = mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM appointments WHERE status='pending' ")); 
$no_of_cancelled_appointments = mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM appointments WHERE status='cancelled' ")); 
$no_of_unread_messages = mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM messages WHERE status='unread' ")); 
$no_of_services = mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM services")); 
$no_of_clients = mysqli_num_rows(mysqli_query($dbconn, "SELECT * FROM users WHERE user_type='client'"));

function new_appointment_cost(){
    global $dbconn;
    $sql = "SELECT SUM(amount) AS total FROM appointments WHERE status='pending' ";
    $result = mysqli_query($dbconn, $sql);

   
    while($row = mysqli_fetch_assoc($result)){
        $total = $row['total'];

        if($total == NULL){
            echo "0";
        }else{
            echo number_format($total,2);

        }
    }
    
}

?>
<section class="kpis">
    <div class="data">
        <h2><a href="./appointments.php?category=pending">New Appointments</a></h2>
        <p><?php echo $no_of_pending_appointments; ?></p>
    </div>
    <div class="data">
        <h2><a href="./messages.php?category=unread">Unread Messages</a></h2>
        <p><?php echo $no_of_unread_messages; ?></p>
    </div>
    <div class="data">
        <h2><a href="./appointments.php?category=pending">New Appointments (Ksh) Value</a></h2>
        <p><?php new_appointment_cost(); ?></p>
    </div>
    <div class="data">
        <h2><a href="./services.php">Services</a></h2>
        <p><?php echo $no_of_services; ?></p>
    </div>
    <div class="data">
        <h2><a href="./appointments.php?category=cancelled">Cancelled Appointments</a></h2>
        <p><?php echo $no_of_cancelled_appointments; ?></p>
    </div>
    <div class="data">
        <h2><a href="./users.php">Number of Clients</a></h2>
        <p><?php echo $no_of_clients; ?></p>
    </div>
</section>