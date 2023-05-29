<section class="hero" id="hero">
            <div class="container">
                <div class="hero-text">
                    <h1>Get a fresh Look</h1>
                    <p>Our main priority is quality</p>
                    <div class="hero-cta">
                        <a href="./book-appointment.php" class="btn btn-primary">Book Appointment</a>
                        <a href="#services" class="btn btn-outline">Our Services</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="./images/hero-image.png" alt="hero image">
                </div>
            </div>
        </section>
        <section class="about" id="about">
            <div class="container">
                <div class="about-image">
                    <img src="./images/about.jpg" alt="about">
                </div>
                <div class="about-text">
                    <h2>About us</h2>
                    <h3>A World Class Beauty Salon</h3>
                    <p>The best services are offered at our salon which is fully funished with technological equipments.</p>
                    <p>Out team is skilled and knowledgeable, providing cutting-edge services in skin, hair and body shaping that will give you a luxurious experience and leave you feeling calm and stress-free.</p>
                    <a href="#services" class="btn btn-primary">Our Services</a>
                </div>

            </div>
        </section>
        <section class="services" id="services">
            <div class="container-2">
                <h2>Our Services</h2>
                <h3>Beauty is not a Luxurious Imagiation</h3>
            </div>
            <div class="container">
                <?php
                //Retrieve data to show on webpage
                $sql = "SELECT * FROM services ORDER BY id DESC";
                
                $stmt = $dbconn->prepare($sql);//prepares the SQL statement for execution by the database.
                $stmt->execute();//executing the prepared statement
                $result = $stmt->get_result();//retrieving the result set from the executed query.
    
               // $index = 0;

                if(mysqli_num_rows($result)>0){// this function checks if the result stored in the variable $result has one or more rows.
                    while($row = mysqli_fetch_assoc($result)){//if rows exists, this while loop fetches for each row using mysqli_fetch_assoc($result)
                        $id = $row['id'];
                        $service_name = $row['service_name'];
                        $service_description = $row['service_description'];
                        $amount = $row['amount'];

                       // $index ++;

                        ?>
                        <div class="service">
                            <h4><?php echo $service_name; ?></h4>
                            <p><?php echo $service_description; ?></p>
                            <p class="price"><?php echo 'Ksh ' . $amount; ?></p>
                            <a href="./book-appointment.php" class="btn  btn-outline">Book Service</a>
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
        </section>
        <section class="contact" id="contact">
            <div class="container-2">
                <h2>Contact us</h2>
                <h3>We'd Love to hear from you</h3>
            </div>
            <div class="container">
                <?php success_message("message_sent","Message sent");?>

                <!-- Error Messages -->
                <?php error_msg("not_sent", "There was an error sending your message, Please try again"); ?>
<!-- a form that uses the POST method to submit data to the ./message.php -->
                <form class="contact-form" action="./message.php" method="POST" id="contact-form">
                    <input type="text" name="name" placeholder="your name" id="name">
                    <input type="text" name="email" placeholder="email" id="email">
                    <input type="text" name="subject" placeholder="subject" id="subject">
                    <textarea name="message" rows="10" placeholder="message" id="message"></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
        </section>

<script>
    //CONTACT VALIDATIONS

    let contactForm = document.getElementById('contact-form');//selecting an HTML element with the ID "contact-form" and assign it to a variable called contactForm. 


    //Prevent form from submitting
    //adds an event listener to the signupForm element for the "submit" event. When the form is submitted, the callback function(e.preventDefault()) is executed.
    contactForm.addEventListener("submit", e=>{
        e.preventDefault();

        checkContacts();//calling this function
    });

    let checkContacts = ()=> {//defining the the function

        //Get the input fields
        let emailInput = document.getElementById('email');
        let nameInput = document.getElementById('name');
        let subjectInput = document.getElementById('subject');
        let messageInput = document.getElementById('message');

        
        //initialize the errors Array
        let errors = [];

        //remove whitespaces from inputs
        let emailValue = emailInput.value.trim();
        let nameValue = nameInput.value.trim();
        let subjectValue = subjectInput.value.trim();
        let messageValue = messageInput.value.trim();

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

        if(nameValue === ''){
            nameInput.className = 'error';
            nameInput.placeholder = "name can't be empty";
            errors.push('empty name');
        }else{
            nameInput.className = 'success';
        }

        if(subjectValue === ''){
            subjectInput.className = 'error';
            subjectInput.placeholder = "subject can't be empty";
            errors.push('empty subject');
        }else{
            subjectInput.className = 'success';
        }

        if(messageValue === ''){
            messageInput.className = 'error';
            messageInput.placeholder = "message can't be empty";
            errors.push('empty message');
        }else{
            messageInput.className = 'success';
        }

        //if the errors array is empty, submit the form
        if (errors.length == 0) {
			contactForm.submit();
		}
 
    }
</script>