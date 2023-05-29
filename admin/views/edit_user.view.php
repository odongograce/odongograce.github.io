<form method="POST" action="./edit_user.php" class="form" id="signup-form">
    <h3>Edit User</h3>

    <!-- Success Message -->
    <?php success_message("account_edited","Account Updated Succesfully");?>
    
    <!-- Error Messages -->
    <?php error_msg("error_updating_Account", "An Error Occured Trying to update your Account! <br > Please try again or contact " . _EMAIL); ?>
    <input type="text" name="firstName" id="firstName" placeholder="First Name" value="<?php echo $firstName; ?>">
    <input type="text" name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $last_name; ?>">
    <input type="text" name="email" id="userEmail" placeholder="Email" value="<?php echo $email; ?>">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $id; ?>">
    <input type="text" name="phone" id="phone" placeholder="Phone: Eg. 0712345678" value="<?php echo $phone; ?>">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
    <button type="submit" class="btn btn-primary">Update Account</button>
</form>

<script>
    //SIGN UP FORM VALIDATIONS

    let signupForm = document.getElementById('signup-form');

    //Prevent form from submitting
    signupForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkSignup();
    });

    let checkSignup = ()=> {
        //Get the input fields
        let fNameInput = document.getElementById('firstName');
        let lNameInput = document.getElementById('lastName');
        let emailInput = document.getElementById('userEmail');
        let phoneInput = document.getElementById('phone');
        let passwordInput = document.getElementById('password');
        let confirmPasswordInput = document.getElementById('confirmPassword');

        console.log(fNameInput, lNameInput);

        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let fNameValue = fNameInput.value.trim();
        let lNameValue = lNameInput.value.trim();
        let emailValue = emailInput.value.trim();
        let phoneValue = phoneInput.value.trim();
        let passwordValue = passwordInput.value.trim();
        let confirmPasswordValue = confirmPasswordInput.value.trim();

        //running a condition to check for empty fields
        if(fNameValue === ''){
            fNameInput.className = 'error';
            fNameInput.placeholder = "name can't be empty";
            errors.push('empty name');
        }else{
            let nameRegExp = /^[a-zA-Z]+$/;

            if (nameRegExp.test(fNameValue) == false){
                fNameInput.className = 'error';
                fNameInput.value = "";
                fNameInput.placeholder = "name can't have numbers";
                errors.push('numbered name');
            }else{
                fNameInput.className = 'success';
            }
        }

        if(lNameValue !== ''){
            let nameRegExp = /^[a-zA-Z]+$/;

            if (nameRegExp.test(lNameValue) == false){
                lNameInput.className = 'error';
                lNameInput.value = "";
                lNameInput.placeholder = "name can't have numbers";
                errors.push('numbered name');
            }else{
                fNameInput.className = 'success';
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

        if(confirmPasswordValue !== passwordValue){
            confirmPasswordInput.className = 'error';
            confirmPasswordInput.value = '';
            confirmPasswordInput.placeholder = "Passwords do not Match";
            errors.push('passwords mismatch');
        }else{

            confirmPasswordInput.className = 'success';
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
			signupForm.submit();
		}
 
    }
</script>

