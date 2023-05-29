<section class="sign-up">
    <div class="container">
        <!-- a form that uses the POST method to submit data to the ./signup.php -->
        <form method="POST" action="./signup.php" class="form" id="signup-form">
            <h2>Sign up</h2>
            <h3>Create Account</h3>
            
            <!-- Error Messages -->
            <?php error_msg("user_exists", "User with that email already Exists"); ?>
            <?php error_msg("registration_error", "An Error Occured trying to register you! <br > Please try again or contact " . _EMAIL); ?>
                
            <input type="text" name="firstName" id="firstName" placeholder="First Name">
            <input type="text" name="email" id="userEmail" placeholder="Email">
            <input type="number" name="phone" id="phone" placeholder="Phone: Eg. 0712345678" id="phone">
            <input type="password" name="password" id="password" placeholder="Password" id="password">
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" id="confirmPassword">
            <button type="submit" class="btn btn-primary">Create Account</button>
            <div class="login-utilities">
                <p>Have an account? <a href="./login.php"><strong>Sign in</strong></a></p>
            </div>
        </form>
    </div>
</section>

<script>
    //SIGN UP FORM VALIDATIONS

    let signupForm = document.getElementById('signup-form');//selecting an HTML element with the ID "signup-form" and assign it to a variable called signupForm. 

    //Prevent form from submitting
    //adds an event listener to the signupForm element for the "submit" event. When the form is submitted, the callback function(e.preventDefault()) is executed.
    signupForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkSignup();//calling this function
    });

    let checkSignup = ()=> {//defining the checksignup function

        //Assigning variables based on the ids
        let nameInput = document.getElementById('firstName');
        let emailInput = document.getElementById('userEmail');
        let phoneInput = document.getElementById('phone');
        let passwordInput = document.getElementById('password');
        let confirmPasswordInput = document.getElementById('confirmPassword');

        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let nameValue = nameInput.value.trim();
        let emailValue = emailInput.value.trim();
        let phoneValue = phoneInput.value.trim();
        let passwordValue = passwordInput.value.trim();
        let confirmPasswordValue = confirmPasswordInput.value.trim();

        //Check Empty Fields
        if(nameValue === ''){
            nameInput.className = 'error';
            nameInput.placeholder = "name can't be empty";
            errors.push('empty name');
        }else{
            //name should only contain characters
            let nameRegExp = /^[a-zA-Z]+$/;

            if (nameRegExp.test(nameValue) == false){
                nameInput.className = 'error';
                nameInput.value = "";
                nameInput.placeholder = "name can't have numbers";
                errors.push('numbered name');
            }else{
                nameInput.className = 'success';
            }
        }

        if(phoneValue === ''){
            phoneInput.className = 'error';
            phoneInput.placeholder = "phone can't be empty";
            errors.push('empty phone');
        }else{
            let phoneRegExp = /^0\d{9}$/;

            if(phoneRegExp.test(phoneValue) == false){
                phoneInput.className = 'error';
                phoneInput.value = "";
                phoneInput.placeholder = "Phone number starts with 0 and has 10 digits";
                errors.push('invalid phone format');

            }else{
                phoneInput.className = 'success';

            }
        }

 
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
        // }else{// password has at least one digit, at least one special character from ! to *, and a minimum length of 5 characters. It allows for a combination of uppercase letters, lowercase letters, digits, and the specified special characters.
        //     let passwordRegExp = /^(?=.*[0-9])(?=.*[!-\\*])[a-zA-Z0-9!-\\*]{5,}$/;
        //      if(passwordRegExp.test(passwordValue) == false){
        //         passwordInput.className = 'error';
        //         passwordInput.placeholder= ""; 
        //         passwordInput.placeholder = "invalid password format";    
        //         errors.push('invalid password');

        // }
        }else{
            passwordInput.className = 'success';
        }

        if(confirmPasswordValue === ''){
            confirmPasswordInput.className = 'error';
            confirmPasswordInput.placeholder = "Confirm Password can't be empty";
            errors.push('empty confirmPassword');
        }else{
            if(confirmPasswordValue !== passwordValue){
                confirmPasswordInput.className = 'error';
                confirmPasswordInput.value = '';
                confirmPasswordInput.placeholder = "Passwords do not Match";
                errors.push('passwords mismatch');
            }else{

                confirmPasswordInput.className = 'success';
            }
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
			signupForm.submit();
		}
 
    }
</script>
