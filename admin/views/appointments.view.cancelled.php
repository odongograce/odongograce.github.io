<section class="appointments">
            <div class="container">
                <ul class="appointment-nav">
                        <?php
                            if(isset($_GET['category'])){
                                $category = $_GET['category'];
                            }
                        ?>
                        <li><a href="./appointments.php" class="<?php echo (!isset($category))? 'active': ''; ?>">All</a></li>
                        <li><a href="./appointments.php?category=approved" class="<?php echo (isset($category) && $category == 'approved')? 'active': ''; ?>">Approved</a></li>
                        <li><a href="./appointments.php?category=pending" class="<?php echo (isset($category) && $category == 'pending')? 'active': ''; ?>">Pending</a></li>
                        <li><a href="./appointments.php?category=cancelled" class="<?php echo (isset($category) && $category == 'cancelled')? 'active': ''; ?>">Cancelled</a></li>
                    </ul>
                <?php success_message("approved","Approved!");?>
                <?php success_message("deleted","Appointment Deleted");?>
                <?php success_message("edited","Appointment updated");?>

                <?php error_msg("error_approving", "An Error Occured Trying Aprove"); ?>
                <?php error_msg("delete_appointment_error", "An Error Occured Trying Delete"); ?>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            //Retrieve data to show on webpage
                            $sql = "SELECT appointments.*, users.first_name, users.email, users.phone FROM appointments
                            LEFT JOIN users ON appointments.user_id = users.id
                            WHERE status = 'cancelled' 
                            ORDER BY id DESC";

                            $stmt = $dbconn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();


                            // exit();
                
                            $index = 0;

                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $services = $row['services'];
                                    $date = $row['date'];
                                    $time = $row['time'];
                                    $amount = $row['amount'];
                                    $status = $row['status'];
                                    $first_name = $row['first_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $paid = $row['paid'];

                                    $index ++;

                                    ?>
                                    <tr>
                                        <td><?php echo $index;?></td>
                                        <td>
                                            <p><?php echo $first_name;?></p>
                                            <p><?php echo $email;?></p>
                                            <p><?php echo $phone;?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $date; ?></p>
                                            <p><?php echo $time; ?></p>
                                        </td>
                                        <td><?php echo $services; ?></td>
                                        <td><?php echo $amount; ?></td>
                                        <td class="<?php echo $paid; ?>">
                                        <?php echo $paid?>
                                        <?php
                                                if(!($paid == 'paid')){
                                                    ?>
                                                        <a href="./paid.php?id=<?php echo $id; ?>" class="btn btn-outline" style="display: block;">Mark as Paid</a>
                                                    
                                                    <?php
                                                }
                                            ?>

                                        </td>
                                        <td class="<?php echo $status; ?>"><?php echo $status?></td>
                                        <td>
                                            <?php
                                                if(!($status == 'approved')){
                                                    ?>
                                                        <a href="./approve.php?id=<?php echo $id; ?>" class="btn btn-primary">Approve</a>
                                                    
                                                    <?php
                                                }
                                            ?>
                                            <a href="./edit_appointment.php?id=<?php echo $id; ?>" class="btn btn-outline">Reschedule</a>
                                            <a href="./delete_appointment.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want Delete this appointment!')" class="btn btn-outline">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="8" style="text-align:center;">No Appointment</td>
                                    </tr>
                                <?php

                            }
                            ?>                        
                    </tbody>
                </table>
            </div>
        </section>
