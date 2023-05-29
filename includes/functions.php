<?php

    // *********************************************************** FORM VALIDATION

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // *********************************************************** ERROR MESSAGE

    function error_msg($get_error, $error_message){
        if(isset($_GET['error']) && ($_GET['error']==$get_error)){
            ?>
            <div class="message message-error" id="message">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <?php echo $error_message; ?>
                </span>          
                <button type="button" class="message-close" id="close">&times;</button> 
                
                <script>
                    let closeBtn = document.getElementById('close');
                    
                    closeBtn.addEventListener("click", function(){
                        let closeDiv = document.getElementById('message');

                        closeDiv.style.display = "none";
                    })
                </script>
            </div>
            <?php
        }
    }

    // *********************************************************** SUCCESS MESSAGE
    
    function success_message($get_status, $status_message){
        if(isset($_GET['status']) && ($_GET['status']==$get_status)){
            ?>
            <div class="message message-success" id="message">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    <span class="text-sm"><?php echo $status_message; ?></span>
                </span>
                <button type="button" class="message-close" id="close">&times;</button>
                
                <script>
                    let closeBtn = document.getElementById('close');
                    
                    closeBtn.addEventListener("click", function(){
                        let closeDiv = document.getElementById('message');

                        closeDiv.style.display = "none";
                    })
                </script>

            </div>
            <?php
        }
    }
?>

