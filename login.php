<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Sign in"; ?>

<?php
// ******************************************************  LOGIN USER: 

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){ //a post method that retrieves the value of email, and psw from post data. The values are then passed through the test_input function for sanitization.
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);

        //  Check User details if email exists by executing a select query
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $dbconn->prepare($sql);//prepares the SQL statement for execution by the database.
        $stmt->bind_param("s", $email);//binds a value to the placeholder in the SQL query   
        $stmt->execute();//calling execute method on the prepared statement object to execute the SQL query with the bound parameter value.
        $result = $stmt->get_result();//retrieving the result set from the executed query.

        if(mysqli_num_rows($result)>0){// this function checks if the result stored in the variable $result has one or more rows.
            while($row = mysqli_fetch_assoc($result)){//if rows exists, this while loop fetches for each row using mysqli_fetch_assoc($result)

                // funtion to verify Password against the stored password hash
                if(password_verify($password, $row['user_password'])){//This function compares the plain-text password ($password) with the hashed password stored in the database ($row['user_password']).

                  
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['userType'] = $row['user_type']; //session variables are set if the password matches to store userid and usertype retrieved from the database


                    if($_SESSION['userType'] == 'client'){
                        header('Location: ./index.php?status=verified');
                    }//users are then redirected to diff. pages depending on the user

                    if($_SESSION['userType'] == 'admin'){
                        header('Location: ./admin/index.php?status=verified');
                    }
                    exit();//function that terminats script if a redirection occures to ensure no further code is executed

                }else{//if pwd does not match, user is directed to the login page with an error msg
                    header('Location: login.php?error=pwd_incorrect');
                    exit();
                }           
            }
        }else{
            header('Location: login.php?error=no_user');
            exit();//function that terminats script if a redirection occures to ensure no further code is executed
        }
        exit();
    }
?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php include './views/login.view.php'; ?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        