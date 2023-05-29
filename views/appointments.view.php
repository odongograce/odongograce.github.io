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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // PAGINATION START

                            // Get the current page
                            if(!isset($_GET['page'])){
                                $page = 1;
                            }else{
                                $page = $_GET['page'];
                            }

                            $results_per_page = 5;
                            $first_page_result = ($page-1) * $results_per_page;

                            //Total number of pages
                            $pagination_sql = "SELECT * FROM appointments WHERE user_id=? ORDER BY id DESC";
                            $stmt = $dbconn->prepare($pagination_sql);
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $number_of_results = mysqli_num_rows($result);
                            $number_of_pages = ceil($number_of_results/$results_per_page);

                            // Pagination End

                            //Retrieve data to show on webpage
                            $sql = "SELECT * 
                            FROM appointments 
                            WHERE user_id=? 
                            ORDER BY id DESC
                            LIMIT $first_page_result, $results_per_page";

                            $stmt = $dbconn->prepare($sql);
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();


                            // exit();
                
                            $index = $first_page_result;

                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
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
                                        <td>
                                            <?php
                                                if($status == "pending"){
                                                    ?>
                                                        <a href="./edit_appointment.php?id=<?php echo $id; ?>" class="btn btn-primary">Reschedule</a>
                                                        <a href="./cancel.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want cancel this appointment!')" class="btn btn-outline">Cancel</a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">You dont have any appointments</td>
                                    </tr>
                                <?php

                            }
                            ?>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="pagitations">
                                    <ul class="pagination-list">
                                        <?php
                                            //START SHOWING PAGINATION LINKS

                                            //If page is greater than one, show the previous page link

                                            //If page is greater than 2, show the first page
                                            if($page > 2){
                                                ?>
                                                    <li><a href="./appointments.php?page=1" class="pagination-link">1</a></li>
                                                    <?php
                                                //If page is greater than 3, show 2 dots
                                                if($page > 3){
                                                    ?>
                                                        <li><a>...</a></li>
                                                        <?php
                                                }
                                            }
                                            
                                            
                                            //Display 1 page before the current page
                                            if($page -1 > 0){
                                                ?>
                                                <li><a href="./appointments.php?page=<?php echo $page - 1; ?>" class="pagination-link">&larr;</a></li>
                                                <?php
                                            }
                                            ?>
                                            <!--Display the current page -->
                                            <li><a href="./appointments.php?page=<?php echo $page; ?>" class="pagination-link current-page"><?php echo $page; ?></a></li>
                                            <?php

                                            //Display 1 page after the current page
                                            if($page + 1 < $number_of_pages + 1){
                                                ?>
                                                <li><a href="./appointments.php?page=<?php echo $page + 1; ?>" class="pagination-link">&rarr;</a></li>
                                                <?php
                                            }

                                            // Display the last Page
                                            if($page < $number_of_pages){
                                                if($page < $number_of_pages - 2){
                                                    ?>
                                                        <li><a>...</a></li>
                                                        <li><a href="./appointments.php?page=<?php echo $number_of_pages; ?>" class="pagination-link"><?php echo $number_of_pages; ?></a></li>

                                                    <?php
                                                }
                                            }


                                            // FINISH SHOWING PAGINATION LINKS
                                            

                                        ?>
                                        
                                        
                                        <!-- <li><a href="#" class="pagination-link">1</a></li>
                                        <li><a href="#" class="pagination-link">2</a></li> -->
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
