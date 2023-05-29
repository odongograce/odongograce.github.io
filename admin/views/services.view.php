<?php success_message("service_added","Service Added");?>
<?php success_message("service_edited","Service Edited");?>
<?php success_message("service_deleted","Service Deleted");?>


<!-- Error Messages -->
<?php error_msg("error_adding_service", "There was an error adding service"); ?>
<?php error_msg("error_editing_service", "There was an error editing service"); ?>
<?php error_msg("error_deleting_service", "There was an error deleting service"); ?>

<ul class="appointment-nav">
    <li><a href="./add_service.php" class="btn btn-otline">Add Service</a></li>
</ul>


<table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Retrieve data to show on webpage
                            $sql = "SELECT * 
                            FROM services
                            ORDER BY id DESC";

                            $stmt = $dbconn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();


                            // exit();
                
                            $index = 0;

                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $service_name = $row['service_name'];
                                    $service_description = $row['service_description'];
                                    $amount = $row['amount'];

                                    $index ++;

                                    ?>
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td><?php echo $service_name; ?></td>
                                        <td><?php echo $service_description; ?></td>
                                        <td><?php echo $amount; ?></td>
                                        <td>
                                            <?php
                                                ?>
                                                    <a href="./edit_service.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="./delete_service.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want to delete service')" class="btn btn-outline">Delete</a>
                                                <?php
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Service</td>
                                    </tr>
                                <?php

                            }
                            ?>                        
                    </tbody>
                </table>