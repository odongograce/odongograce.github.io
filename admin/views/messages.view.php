<section class="appointments">
            <div class="container">
                <ul class="appointment-nav">
                        <?php
                            if(isset($_GET['category'])){
                                $category = $_GET['category'];
                            }
                        ?>
                        <li><a href="./messages.php" class="<?php echo (!isset($category))? 'active': ''; ?>">All</a></li>
                        <li><a href="./messages.php?category=unread" class="<?php echo (isset($category) && $category == 'unread')? 'active': ''; ?>">Unread</a></li>
                        <li><a href="./messages.php?category=read" class="<?php echo (isset($category) && $category == 'read')? 'active': ''; ?>">Read</a></li>
                    </ul>
                <?php success_message("read","Message Read");?>
                <?php success_message("message_deleted","Message Deleted");?>

                <?php error_msg("error_read", "Not marked as read"); ?>
                <?php error_msg("error_delete_message", "Message Not Deleted"); ?>

                <table>
                <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
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
                            $pagination_sql = "SELECT * FROM messages ORDER BY id DESC";
                            $stmt = $dbconn->prepare($pagination_sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $number_of_results = mysqli_num_rows($result);
                            $number_of_pages = ceil($number_of_results/$results_per_page);

                            // Pagination End

                            //Retrieve data to show on webpage
                            $sql = "SELECT * 
                            FROM messages 
                            ORDER BY id DESC
                            LIMIT $first_page_result, $results_per_page";

                            $stmt = $dbconn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();


                            // exit();
                
                            $index = $first_page_result;

                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $email = $row['email'];
                                    $subject = $row['subject'];
                                    $message = $row['message'];
                                    $status = $row['status'];
                                    $date = $row['date'];
                                    $time = $row['time'];

                                    $index ++;

                                    ?>
                                    <tr>
                                        <td><?php echo $index;?></td>
                                        <td><?php echo $name;?></td>
                                        <td><?php echo $email;?></td>
                                        <td>
                                            <p><strong><?php echo $subject; ?></strong></p>
                                            <p><?php echo $message; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $date; ?></p>
                                            <p><?php echo $time; ?></p>
                                        </td>
                                        <td class="<?php echo $status; ?>"><?php echo $status; ?></td>
                                        <td>
                                            <?php
                                            if ($status == 'unread'){
                                                ?>
                                                    <a href="./mark_read.php?id=<?php echo $id; ?>" class="btn btn-primary">Mark as Read</a>

                                                <?php
                                            }
                                                ?>
                                                    <a href="./delete_message.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want cancel this message!')" class="btn btn-outline">Delete</a>
                                                <?php
                                            ?>
                                            <a href="mailto:<?php echo $email; ?>" class="btn btn-outline">Reply</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Messages</td>
                                    </tr>
                                <?php

                            }
                            ?>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="pagitations">
                                    <ul class="pagination-list">
                                        <?php
                                            //START SHOWING PAGINATION LINKS

                                            //If page is greater than one, show the previous page link

                                            //If page is greater than 2, show the first page
                                            if($page > 2){
                                                ?>
                                                    <li><a href="./messages.php?page=1" class="pagination-link">1</a></li>
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
                                                <li><a href="./messages.php?page=<?php echo $page - 1; ?>" class="pagination-link">&larr;</a></li>
                                                <?php
                                            }
                                            ?>
                                            <!--Display the current page -->
                                            <li><a href="./messages.php?page=<?php echo $page; ?>" class="pagination-link current-page"><?php echo $page; ?></a></li>
                                            <?php

                                            //Display 1 page after the current page
                                            if($page + 1 < $number_of_pages + 1){
                                                ?>
                                                <li><a href="./messages.php?page=<?php echo $page + 1; ?>" class="pagination-link">&rarr;</a></li>
                                                <?php
                                            }

                                            // Display the last Page
                                            if($page < $number_of_pages){
                                                if($page < $number_of_pages - 2){
                                                    ?>
                                                        <li><a>...</a></li>
                                                        <li><a href="./messages.php?page=<?php echo $number_of_pages; ?>" class="pagination-link"><?php echo $number_of_pages; ?></a></li>

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
