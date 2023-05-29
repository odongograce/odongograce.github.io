// {
//     //LOG IN FORM VALIDATIONS

//     let loginForm = document.getElementById('login-form');
//     let contactForm = document.getElementById('contact-form');

//     //Prevent form from submitting
//     loginForm.addEventListener("submit", e=>{
//         e.preventDefault();

//         checkLogins();
//     });

//     contactForm.addEventListener("submit", e=>{
//         e.preventDefault();

//         checkContacts();
//     });

//     let checkLogins = ()=> {

//         //Get the input fields
//         let emailInput = document.getElementById('email');
//         let passwordInput = document.getElementById('password');

        
//         //initialize the errors Array
//         let errors = [];

//         //remove whitespaces from inputs
//         let emailValue = emailInput.value.trim();
//         let passwordValue = passwordInput.value.trim();

//         //Check Empty Fields
//         if(emailValue === ''){
//             emailInput.className = 'error';
//             emailInput.placeholder = "email can't be empty";
//             errors.push('empty email');
//         }else{
//             //Validate using regex
//             let regExp = /\S+@\S+\.\S+/;

//             if(regExp.test(emailValue) == false){
//                 emailInput.className = 'error';
//                 emailInput.value = "";
//                 emailInput.placeholder = "invalid email format";    
//                 errors.push('invalid email');
//             }else{
//                 emailInput.className = 'success';
//             }

//         }

//         if(passwordValue === ''){
//             passwordInput.className = 'error';
//             passwordInput.placeholder = "password can't be empty";
//             errors.push('empty password');
//         }else{
//             passwordInput.className = 'success';
//         }

//         //if the errors array is empty, submit the form
//         if (errors.length == 0) {
// 			loginForm.submit();
// 		}
 
//     }

//     // CHECK CONTACTS
//     let checkContacts = ()=> {

//         //Get the input fields
//         let emailInput = document.getElementById('email');
//         let nameInput = document.getElementById('name');
//         let subjectInput = document.getElementById('subject');
//         let messageInput = document.getElementById('message');

        
//         //initialize the errors Array
//         let errors = [];

//         //remove whitespaces from inputs
//         let emailValue = emailInput.value.trim();

//         //Check Empty Fields
//         if(emailValue === ''){
//             emailInput.className = 'error';
//             emailInput.placeholder = "email can't be empty";
//             errors.push('empty email');
//         }else{
//             //Validate using regex
//             let regExp = /\S+@\S+\.\S+/;

//             if(regExp.test(emailValue) == false){
//                 emailInput.className = 'error';
//                 emailInput.value = "";
//                 emailInput.placeholder = "invalid email format";    
//                 errors.push('invalid email');
//             }else{
//                 emailInput.className = 'success';
//             }

//         }


//         //if the errors array is empty, submit the form
//         if (errors.length == 0) {
// 			loginForm.submit();
// 		}
 
//     }


// }

