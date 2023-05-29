<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<!-- Set the Page Title -->
<?php $page_title = "Create Your Account"; ?>

<?php
// REGISTER USER

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){ //this method is a post, it retrieves the value of fname,email,psw,phone and usertype from post data. The values are then passed through the test_input function for sanitization.
    $first_name = test_input($_POST['firstName']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $phone = test_input($_POST['phone']);
    $userType = test_input("client");
    
    //check if email exists by excecuting an SQL select query on a db.
    $sql = "SELECT * FROM users WHERE email=?";     
    $stmt = $dbconn->prepare($sql);//prepares the SQL statement for execution by the database.
    $stmt->bind_param("s", $email);//binds a value to the placeholder in the SQL query   
    $stmt->execute(); //calling execute method on the prepared statement object to execute the SQL query with the bound parameter value.
    $result = $stmt->get_result(); // "get_result" method is used to retrieve the result set from the executed query.

//this function checks if the results obtained above has 0 rows . if so, then the email is available for registration
    if(mysqli_num_rows($result)==0){
        //Hash Password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Register User
        $stmt = $dbconn->prepare("INSERT INTO users (first_name, email, user_password, phone, user_type) VALUES (?,?,?,?,?)");//this codes prepares an sql staement to insert a new user into the "users" table. placeholder values(first_name, email, user_password, phone, user_type)
       $stmt->bind_param("sssss", $first_name, $email, $hashed_password, $phone,  $userType); //a method used when binding placeholder values to their variables
       
//exceuting the insert statement. if successful, user is redirected to the login page.
        if($stmt->execute()){
            header('Location: login.php?status=registration_success');   
            //closing the prepared statement and the db connection.      
            $stmt->close();
            $conn->close();
            exit();//function that terminats script if a redirection occures to ensure no further code is executed
        }else{
            header('Location: signup.php?error=registration_error');
            exit();
        }

    }else{
        header('Location: signup.php?error=user_exists');
        exit();
    }
}
?>

<!-- Header Section -->
<?php include './views/header.view.php'; ?>

<?php include './views/signup.view.php'; ?>

<!-- Footer Section -->
<?php include './views/footer.view.php'; ?>
        