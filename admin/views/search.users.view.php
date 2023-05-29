<?php success_message("user_deleted","User Deleted!");?>
<?php success_message("account_edited","Account Updated Succesfully");?>


<!-- Error Messages -->
<?php error_msg("delete_user_error", "There was an error deleting user"); ?>
<?php error_msg("select_user", "Select User to Edit"); ?>

<p>Search results for: <strong><?php echo $_GET['search']; ?></strong></p>

<div class="appointment-nav">
    <form action="./search.php" method="GET" class="search-form" id="search-form">
        <input type="text" name="search" placeholder="Enter user details ..." id="search">
        <button type="submit">Search</button>
    </form>
</div>
<table>
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
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
                            $user_type = 'client';
                            $pagination_sql = "SELECT * 
                            FROM users
                            WHERE user_type = 'client' 
                            AND MATCH(first_name, last_name, email, phone) AGAINST('$search_query' IN NATURAL LANGUAGE MODE)
                            ORDER BY id DESC";
                            // $pagination_sql = "SELECT * FROM users WHERE user_type=? ORDER BY id DESC";
                            $stmt = $dbconn->prepare($pagination_sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $number_of_results = mysqli_num_rows($result);
                            $number_of_pages = ceil($number_of_results/$results_per_page);

                            // Pagination End

                            //Retrieve data to show on webpage
                            // "SELECT * FROM my_table WHERE MATCH (content) AGAINST ('$search_term')"
                            $sql = "SELECT * 
                            FROM users
                            WHERE user_type = 'client' 
                            AND MATCH(first_name, last_name, email, phone) AGAINST('$search_query' IN NATURAL LANGUAGE MODE)
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
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];

                                    $index ++;

                                    ?>
                                    <tr>
                                        <td><?php echo $index?></td>
                                        <td><?php echo $first_name?></td>
                                        <td><?php echo $last_name?></td>
                                        <td><?php echo $email?></td>
                                        <td><?php echo $phone?></td>
                                        <td>
                                            <?php
                                                ?>
                                                    <a href="./edit_user.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="./delete_user.php?id=<?php echo $id; ?>" onclick="alert('Are you sure you want to delete user')" class="btn btn-outline">Delete</a>
                                                <?php
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center;">No users found</td>
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
                                                    <li><a href="./search.php?search=<?php echo $search_query; ?>&page=1" class="pagination-link">1</a></li>
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
                                                <li><a href="./search.php?search=<?php echo $search_query; ?>&page=<?php echo $page - 1; ?>" class="pagination-link">&larr;</a></li>
                                                <?php
                                            }
                                            ?>
                                            <!--Display the current page -->
                                            <li><a href="./search.php?search=<?php echo $search_query; ?>&page=<?php echo $page; ?>" class="pagination-link current-page"><?php echo $page; ?></a></li>
                                            <?php

                                            //Display 1 page after the current page
                                            if($page + 1 < $number_of_pages + 1){
                                                ?>
                                                <li><a href="./search.php?search=<?php echo $search_query; ?>&page=<?php echo $page + 1; ?>" class="pagination-link">&rarr;</a></li>
                                                <?php
                                            }

                                            // Display the last Page
                                            if($page < $number_of_pages){
                                                if($page < $number_of_pages - 2){
                                                    ?>
                                                        <li><a>...</a></li>
                                                        <li><a href="./search.php?search=<?php echo $search_query; ?>&page=<?php echo $number_of_pages; ?>" class="pagination-link"><?php echo $number_of_pages; ?></a></li>

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
