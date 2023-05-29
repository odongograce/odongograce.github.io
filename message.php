<!-- Require Core Modules -->
<?php include './includes/core.php'; ?>

<?php
// ******************************************************  SEND MESSAGE

    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){//a post method that retrieves the value of name,email,sub and message from post data. The values are then passed through the test_input function for sanitization.
        
        $name = test_input($_POST['name']);
        $email = test_input($_POST['email']);
        $subject = test_input($_POST['subject']);
        $message = test_input($_POST['message']);

        //an SQL statement to insert the sanitized values into the 'messages' table.
        $stmt = $dbconn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?,?,?,?)");        
        $stmt->bind_param("ssss",$name, $email, $subject, $message);//binding the sanitized variables to their placeholders 

 // executing the insert statement If successful, user is directed to the index page.
        if($stmt->execute()){          
            header('Location: index.php?status=message_sent#contact');
           
            //if unsuccessful, user is directed to the index page.
        } else{
            header('Location: index.php?error=not_sent#contact');        
        } 
         
        //closing the prepared statement and the db connection.  
        $stmt->close();
        $conn->close();
        exit();

    }
?>