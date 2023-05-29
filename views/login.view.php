<section class="login">
    <div class="container">
        <!-- a form that uses the POST method to submit data to the ./login.php -->
        <form method="POST" action="./login.php" class="form" id="login-form">
            
            <h2>Login</h2>
            <h3>Sign In</h3>
            <!-- Success Messages -->
            <?php success_message("registration_success","You have succesfully registered");?>
            <?php success_message("logged_out","You have succesfully Logged out");?>

            <!-- Error Messages -->
            <?php error_msg("no_user", "no user with that email found"); ?>
            <?php error_msg("pwd_incorrect", "Your Password is incorrect"); ?>
            <?php error_msg("log_in", "Log in to book appointments"); ?>
            <?php error_msg("user", "Login as admin to access this page"); ?>

            <input type="text" name="email" id="email" placeholder="Your Email">
            <input type="password" name="password" id="password" placeholder="Password">
            <button type="submit" class="btn btn-primary">Log In</button>
            <div class="login-utilities">
                <p>New User? <a href="./signup.php"><strong>Sign up</strong></a></p>
                <a href="#" onclick="alert('Contact admin on: <?php echo _EMAIL; ?>')">Forgot Password?</a>
            </div>
        </form>
    </div>
</section>

<script>
    //LOG IN FORM VALIDATIONS

    let loginForm = document.getElementById('login-form');//selecting an HTML element with the ID "login-form" and assign it to a variable called login-form. 

    //Prevent form from submitting
    //adds an event listener to the loginForm element for the "submit" event. When the form is submitted, the calllback function(e.preventDefault()) is executed.
    loginForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkLogins();//calling this functio
    });

    let checkLogins = ()=> {//defining the checkslogins function

        //Get the input fields
        let emailInput = document.getElementById('email');
        let passwordInput = document.getElementById('password');

        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let emailValue = emailInput.value.trim();
        let passwordValue = passwordInput.value.trim();

        //Check Empty Fields
        if(emailValue === ''){
            emailInput.className = 'error';
            emailInput.placeholder = "email can't be empty";
            errors.push('empty email');
        }else{
            //Validate using regex
            let regExp = /\S+@\S+\.\S+/;

            if(regExp.test(emailValue) == false){
                emailInput.className = 'error';
                emailInput.value = "";
                emailInput.placeholder = "invalid email format";    
                errors.push('invalid email');
            }else{
                emailInput.className = 'success';
            }

        }

        if(passwordValue === ''){
            passwordInput.className = 'error';
            passwordInput.placeholder = "password can't be empty";
            errors.push('empty password');
        }else{
            passwordInput.className = 'success';
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
			loginForm.submit();
		}
 
    }
</script>
