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

                            //Retrieve data to show on webpage
                            $sql = "SELECT * 
                            FROM messages 
                            WHERE status = 'read'
                            ORDER BY id DESC";

                            $stmt = $dbconn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                
                            $index = 0;

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
                                                ?>
                                                    <a href="./delete_message.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want cancel this message!')" class="btn btn-outline">Delete</a>
                                                <?php
                                            ?>
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
                </table>
            </div>
        </section>
