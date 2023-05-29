<section class="login">
            <div class="container">
                <form method="POST" action="./edit_appointment.php" class="form" id="appointment-form">
                    <h3>Edit Appointment</h3>
                    
                    <!-- Error Messages -->
                    <?php error_msg("error_updating_appointment", "There was an error updating appointment, Please try again!"); ?>

                    <label id="service-label">Select Service(s):</label>
                    <div class="form-services">
                    <?php
                            //Retrieve data to show on webpage
                            $sql = "SELECT * FROM services ORDER BY id DESC";
                            
                            $stmt = $dbconn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                
                            $index = 0;

                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $service_name = $row['service_name'];
                                    $service_description = $row['service_description'];
                                    $service_amount = $row['amount'];

                                    $index ++;

                                    ?>
                                    <div class="service-checkbox">
                                        <input type="checkbox" name="service[]" value="<?php echo $service_name; ?>" id="service-<?php echo $id; ?>" data-price="<?php echo $service_amount; ?>" <?php echo (in_array($service_name, $services))? 'checked': ''; ?> class="service-check">
                                        <label for="service-<?php echo $id; ?>"><?php echo $service_name . ", Ksh " . $service_amount ; ?></label>
                                    </div>


                                    <?php
                                }
                            }else{
                                ?>
                                <div class="service">
                                    <p>No Service yet</p>
                                </div>                    
                            <?php
                            }
                            ?> 
                    </div>
                    
                    <input type="hidden" name="appointment_id" value="<?php echo $_GET['id']; ?>">
                    <label for="appointmentDate" id="date-label">Date</label>
                    <input type="date" name="date" id="appointmentDate" value="<?php echo $date; ?>">
                    <label for="appointmentTime" id="time-label">Time</label>
                    <input type="time" name="time" id="appointmentTime" value="<?php echo $time; ?>">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" value="<?php echo $amount; ?>" readonly>
                    <button type="submit" class="btn btn-primary">EDIT APPOINTMENT</button>
                </form>
            </div>
        </section>

        <script>
    //APPOINTMENT VALIDATIONS

    let appointmentForm = document.getElementById('appointment-form');
    let checkBoxesInput = document.querySelectorAll('.service-check');
    let amountInput = document.getElementById('amount');

    let kshAmount = amountInput.value * 1;


    //Prevent form from submitting
    appointmentForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkAppointments();
    });

    let checkAppointments = ()=> {

        //Get the input fields
        let dateInput = document.getElementById('appointmentDate');
        let timeInput = document.getElementById('appointmentTime');
        
        // labels
        let dateLabel = document.getElementById('date-label');
        let timeLabel = document.getElementById('time-label');
        let serviceLabel = document.getElementById('service-label');
        

        // console.log(checkBoxesInput);

        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let dateValue = dateInput.value.trim();
        let timeValue = timeInput.value.trim();
        let amountValue = amountInput.value.trim();


        if(dateValue === ''){
            dateInput.className = 'error';
            dateLabel.className = 'error';
            dateLabel.innerHTML = "date can't be empty";
            errors.push('empty date');
        }else{
            //Check if a date is in the past
            let today = new Date();
            let userDate = new Date(dateValue);

            if (userDate < today){
                dateInput.className = 'error';
                dateLabel.className = 'error';
                dateLabel.innerHTML = "choose a date from tommorow";
                errors.push('past date');
            }else{

                dateLabel.innerHTML = "date";
                dateLabel.className = 'success';
                dateInput.className = 'success';
            }

        }

        if(timeValue === ''){
            timeInput.className = 'error';
            timeLabel.className = 'error';
            timeLabel.innerHTML = "time can't be empty";
            errors.push('empty time');
        }else{
            let submitedTime = new Date("1970-01-01T" + timeValue + ":00");
            let startTime = new Date("1970-01-01T08:00:00");
            let endTime = new Date("1970-01-01T20:00:00");

            if(submitedTime < startTime || submitedTime > endTime){
                timeInput.className = 'error';
                timeLabel.className = 'error';
                timeLabel.innerHTML = "Booking Hours are from 8:00 AM to 8:00 PM";
                errors.push('off time');

            }else{
                timeLabel.innerHTML = "time";
                timeLabel.className = 'success';
                timeInput.className = 'success';
            }
        }

        if(amountValue === '' || amountValue == 0){
            serviceLabel.className = 'error';
            serviceLabel.innerHTML = "Select a service";
            errors.push('empty amount');
        }else{
            serviceLabel.className = 'success';
        }

        
        
        //if the errors array is empty, submit the form
        if (errors.length == 0) {
            appointmentForm.submit();
		}
        
    }

    for (let i = 0; i < checkBoxesInput.length; i++) {
        const checkBoxInput = checkBoxesInput[i];

        checkBoxInput.addEventListener('change', function(){
            let amount = checkBoxInput.getAttribute('data-price') * 1;

            if(checkBoxInput.checked){
                kshAmount += amount;
            }else{
                kshAmount -= amount;
            }

            if(kshAmount < 0){
                kshAmount = 0;
            }

            amountInput.value = kshAmount;


        })
    }


    
</script>
