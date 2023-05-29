<section class="appointments">
            <div class="container">
                <nav>
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
                        <li><a href="./book-appointment.php" class="btn btn-outline book">Book Appointment</a></li>
                    </ul>
                </nav>
                <?php success_message("appointment_sent","Appointment booked succesfully, You'll be contacted shortly!");?>
                <?php success_message("cancelled","Appointment cancelled");?>
                <?php success_message("appointment_updated","Appointment updated sucesfully");?>
                <table>
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Appointment Date</th>
                            <th>Time</th>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $status = 'cancelled';
                            $sql = "SELECT * FROM appointments WHERE user_id=? AND status=? ORDER BY id DESC";
                            $stmt = $dbconn->prepare($sql);
                            $stmt->bind_param("is", $_SESSION['user_id'],$status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                
                            $index = 0;

                            if(mysqli_num_rows($result)>0){// this function checks if the result stored in the variable 
                                while($row = mysqli_fetch_assoc($result)){//if rows exists, this while loop fetches for each row using mysqli_fetch_assoc($result)
                                    $id = $row['id'];
                                    $services = $row['services'];
                                    $date = $row['date'];
                                    $time = $row['time'];
                                    $amount = $row['amount'];
                                    $status = $row['status'];
                                    $paid = $row['paid'];

                                    $index ++;

                                    ?>
                                    <tr>
                                        <td><?php echo $index;?></td>
                                        <td><?php echo $date;?></td>
                                        <td><?php echo $time;?></td>
                                        <td><?php echo $services;?></td>
                                        <td><?php echo $amount;?></td>
                                        <td class="<?php echo $status; ?>"><?php echo $status;?></td>
                                        <td class="<?php echo $paid; ?>"><?php echo $paid;?></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">You dont have any <?php echo $status; ?> appointments</td>
                                    </tr>
                                <?php

                            }
                            ?>                        
                    </tbody>
                </table>
            </div>
        </section>
