<section class="appointments">
            <div class="container">
            <p>Search results for: <strong><?php echo $_GET['search']; ?></strong></p>

<div class="appointment-nav">
    <form action="./search_appointment.php" method="GET" class="search-form" id="search-form">
        <input type="text" name="search" placeholder="Enter user details ..." id="search">
        <button type="submit">Search</button>
    </form>
</div>
                <?php success_message("approved","Approved!");?>
                <?php success_message("paid","Payment Received!");?>
                <?php success_message("deleted","Appointment Deleted");?>
                <?php success_message("edited","Appointment updated");?>

                <?php error_msg("error_approving", "An Error Occured Trying Aprove"); ?>
                <?php error_msg("error_paid", "An Error Occured Marking as Paid! please try again!"); ?>
                <?php error_msg("delete_appointment_error", "An Error Occured Trying Delete"); ?>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $search_query = $_GET['search'];

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
                            $pagination_sql = "SELECT appointments.*, users.first_name, users.email, users.phone FROM appointments 
                            LEFT JOIN users ON appointments.user_id = users.id
                            WHERE user_type = 'client' 
                            AND MATCH(users.first_name, users.last_name, users.email, users.phone) AGAINST('$search_query' IN NATURAL LANGUAGE MODE)
                            ORDER BY id DESC";
                            $stmt = $dbconn->prepare($pagination_sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $number_of_results = mysqli_num_rows($result);
                            $number_of_pages = ceil($number_of_results/$results_per_page);

                            // Pagination End

                            //Retrieve data to show on webpage
                            $sql = "SELECT appointments.*, users.first_name, users.email, users.phone FROM appointments 
                            LEFT JOIN users ON appointments.user_id = users.id
                            WHERE user_type = 'client' 
                            AND MATCH(users.first_name, users.last_name, users.email, users.phone) AGAINST('$search_query' IN NATURAL LANGUAGE MODE)
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
                                    $services = $row['services'];
                                    $date = $row['date'];
                                    $time = $row['time'];
                                    $amount = $row['amount'];
                                    $status = $row['status'];
                                    $first_name = $row['first_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];

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
                                        <td class="<?php echo $status; ?>"><?php echo $status?></td>
                                        <td>
                                            <?php
                                                if(!($status == 'approved')){
                                                    ?>
                                                        <a href="./approve.php?id=<?php echo $id; ?>" class="btn btn-primary">Approve</a>
                                                    
                                                    <?php
                                                }
                                            ?>
                                            <a href="./edit_appointment.php?id=<?php echo $id; ?>" class="btn btn-outline">Edit</a>
                                            <a href="./delete_appointment.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want Delete this appointment!')" class="btn btn-outline">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No Appointment found</td>
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
                                                    <li><a href="./search_appointment.php?search=<?php echo $search_query; ?>&page=1" class="pagination-link">1</a></li>
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
                                                <li><a href="./search_appointment.php?search=<?php echo $search_query; ?>&page=<?php echo $page - 1; ?>" class="pagination-link">&larr;</a></li>
                                                <?php
                                            }
                                            ?>
                                            <!--Display the current page -->
                                            <li><a href="./search_appointment.php?search=<?php echo $search_query; ?>&page=<?php echo $page; ?>" class="pagination-link current-page"><?php echo $page; ?></a></li>
                                            <?php

                                            //Display 1 page after the current page
                                            if($page + 1 < $number_of_pages + 1){
                                                ?>
                                                <li><a href="./search_appointment.php?search=<?php echo $search_query; ?>&page=<?php echo $page + 1; ?>" class="pagination-link">&rarr;</a></li>
                                                <?php
                                            }

                                            // Display the last Page
                                            if($page < $number_of_pages){
                                                if($page < $number_of_pages - 2){
                                                    ?>
                                                        <li><a>...</a></li>
                                                        <li><a href="./search_appointment.php?search=<?php echo $search_query; ?>&page=<?php echo $number_of_pages; ?>" class="pagination-link"><?php echo $number_of_pages; ?></a></li>

                                                    <?php
                                                }
                                            }


                                            // FINISH SHOWING PAGINATION LINKS
                                            

                                        ?>
                                        
                                        
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <script>
    //search VALIDATIONS

    let searchForm = document.getElementById('search-form');


    //Prevent form from submitting
    searchForm.addEventListener("submit", e=>{
        e.preventDefault();

        checksearchs();
    });

    let checksearchs = ()=> {

        //Get the input fields
        let searchInput = document.getElementById('search');
        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let searchValue = searchInput.value.trim();


        if(searchValue === ''){
            searchInput.className = 'error';
            searchInput.value = '';
            searchInput.placeholder = "Enter Search Value";
            errors.push('enter search');
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
            searchForm.submit();
		}
        
    }

</script>
