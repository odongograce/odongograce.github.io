<form action="./edit_service.php" method="post" class="form" id="service-form">
    <h3>Edit Service</h3>
    <!-- Error Messages -->
    <?php error_msg("error_adding_service", "There was an error adding service! Please Try Again"); ?>

    <input type="hidden" name="service_id" value="<?php echo $_GET['id']; ?>">
    <input type="text" name="serviceName" id="service-name" placeholder="Service" value="<?php echo $service_name; ?>">
    <textarea name="description" rows="10" placeholder="Description" id="service-description"><?php echo $service_description; ?></textarea>
    <input type="number" name="serviceAmount" id="service-amount" placeholder="Amount" value="<?php echo $amount; ?>">
    <button type="submit" class="btn btn-primary">Edit Service</button>
</form>

<script>
    //SERVICE FORM VALIDATIONS

    let serviceForm = document.getElementById('service-form');

    //Prevent form from submitting
    serviceForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkServices();
    });

    let checkServices = ()=> {

        //Get the input fields
        let nameInput = document.getElementById('service-name');
        let descriptionInput = document.getElementById('service-description');
        let amountInput = document.getElementById('service-amount');
        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let nameValue = nameInput.value.trim();
        let descriptionValue = descriptionInput.value.trim();
        let amountValue = amountInput.value.trim();

        //running a condition to check for empty fields

        if(nameValue === ''){
            nameInput.className = 'error';
            nameInput.placeholder = "Service name can't be empty";
            errors.push('empty name');
        }else{
            nameInput.className = 'success';
        }

        if(descriptionValue === ''){
            descriptionInput.className = 'error';
            descriptionInput.placeholder = "description can't be empty";
            errors.push('empty description');
        }else{
            descriptionInput.className = 'success';
        }

        if(amountValue === '' || amountValue == 0){
            amountInput.className = 'error';
            amountInput.value = '';
            amountInput.placeholder = "amount can't be empty";
            errors.push('empty amount');
        }else{
            amountInput.className = 'success';
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
			serviceForm.submit();
		}
 
    }
</script>
