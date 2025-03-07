<footer class="footer-area">
      <div class="container">
         <div class="footer-copyright d-flex align-items-center justify-content-center gap-3">
            <p class="copyright-text mb-0">© 2024 Pocket Ledger Private Ltd,</p>
            <ul class="copyright-links d-flex align-items-center gap-2">
               <li><a href="#" class="text-decoration-underline">Terms of Use</a></li>
               <li><a href="#" class="text-decoration-underline">Privacy</a></li>
            </ul>
         </div>
      </div>
   </footer>
   <!-- footer area end -->

   <!-- Optional JavaScript; choose one of the two! -->
   <script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
   <script src="{{ asset('assets/js/popper.min.js')}}"></script>
   <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
   <script src="{{ asset('assets/js/swiper-bundle.min.js')}}"></script>
   <script src="{{ asset('assets/js/main.js')}}"></script>
   <script>
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("signupForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // First Name Validation
        const first_name = document.getElementById("first_name");
        const firstnameError = document.getElementById("firstnameError");
        if (first_name.value.trim() === "") {
            firstnameError.innerText = "First Name is required.";
            isValid = false;
        } else {
            firstnameError.innerText = "";
        }

        // Last Name Validation
        const last_name = document.getElementById("last_name");
        const lastnameError = document.getElementById("lastnameError");
        if (last_name.value.trim() === "") {
            lastnameError.innerText = "Last Name is required.";
            isValid = false;
        } else {
            lastnameError.innerText = "";
        }

        // Email Validation
        const email = document.getElementById("email");
        const emailError = document.getElementById("emailError");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
            emailError.innerText = "Valid email is required.";
            isValid = false;
        } else {
            emailError.innerText = "";
        }

        // Country Validation
        const country = document.getElementById("country");
        const countryError = document.getElementById("countryError");
        if (country.value === "") {
            countryError.innerText = "Please select a country.";
            isValid = false;
        } else {
            countryError.innerText = "";
        }

        // Phone Number Validation
        const phone = document.getElementById("phone_number");
        const phoneError = document.getElementById("phoneError");
        const phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phone.value.trim())) {
            phoneError.innerText = "Phone number must be 10 digits.";
            isValid = false;
        } else {
            phoneError.innerText = "";
        }

        // Password Validation
        const password = document.getElementById("password");
        const passwordError = document.getElementById("passwordError");
        if (password.value.length < 8) {
            passwordError.innerText = "Password must be at least 6 characters.";
            isValid = false;
        } else {
            passwordError.innerText = "";
        }

        // Checkbox Validation
        const checkbox = document.getElementById("agreement");
        const checkboxError = document.getElementById("agreementError");
        if (!checkbox.checked) {
            checkboxError.innerText = "You must accept the Terms and Conditions.";
            isValid = false;
        } else {
            checkboxError.innerText = "";
        }

        // If all validations pass, submit the form using AJAX
        if (isValid) {
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href='/verify-email';
                } else {
                  commonError.innerText = data.error;
                }
            })
            .catch(error => {
               commonError.innerText = error;
            });
        }
    });
});
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;
        let commonError=document.getElementById('commonError');
        // Email Validation
        const email = document.getElementById("email");
        const emailError = document.getElementById("emailError");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
            emailError.innerText = "Valid email is required.";
            isValid = false;
        } else {
            emailError.innerText = "";
        }

        // Password Validation
        const password = document.getElementById("password");
        const passwordError = document.getElementById("passwordError");
        if (password.value.length < 6) {
            passwordError.innerText = "Valid Password is required.";
            isValid = false;
        } else {
            passwordError.innerText = "";
        }

        // If all validations pass, submit the form using AJAX
        if (isValid) {
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  window.location.href = "/dashboard";
                } else {
                  commonError.innerText = 'Invalid Email and Password.';
                }
            })
            .catch(error => {
               commonError.innerText = error;
            });
        }
    });
});
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("verification");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // First Name Validation
        const verification_code = document.getElementById("confirmation");
        const verificationCodeError = document.getElementById("verificationCodeError");
        const verificationPattern = /^\d{6}$/;
        if (!verificationPattern.test(verification_code.value.trim())) {
         verificationCodeError.innerText = "Verification code must be 6 digits.";
            isValid = false;
        } else {
         verificationCodeError.innerText = "";
        }

        // If all validations pass, submit the form using AJAX
        if (isValid) {
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  window.location.href = "/setup-account"; // Redirect to setup-account page
                } else {
                  verificationCodeError.innerText = "Invalid Verification code.";
                }
            })
            .catch(error => {
               verificationCodeError.innerText = error;
            });
        }
    });
});
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("accountForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // First Name Validation
        const first_name = document.getElementById("f-name");
        const firstnameError = document.getElementById("firstnameError");
        if (first_name.value.trim() === "") {
            firstnameError.innerText = "First Name is required.";
            isValid = false;
        } else {
            firstnameError.innerText = "";
        }

        // Last Name Validation
        const last_name = document.getElementById("l-name");
        const lastnameError = document.getElementById("lastnameError");
        if (last_name.value.trim() === "") {
            lastnameError.innerText = "Last Name is required.";
            isValid = false;
        } else {
            lastnameError.innerText = "";
        }

        // Country Validation
        const gender = document.getElementById("select-gender");
        const genderError = document.getElementById("genderError");
        if (gender.value === "") {
         genderError.innerText = "Please select a gender.";
            isValid = false;
        } else {
         genderError.innerText = "";
        }
        // If all validations pass, submit the form using AJAX
        if (isValid) {
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  window.location.href = "/dashboard"; //
                } else {
                    alert("Something went wrong, please try again.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    });
});
</script>
   <script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.submit-question').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.question-form');
            const nextModalId = form.getAttribute('data-next-modal');
            const formData = new FormData(form);
            const errorSpan = form.querySelector('.error-message'); // Ensure the error span is specific to the form
               // Clear any previous error message
               errorSpan.textContent = '';
               errorSpan.classList.remove('alert', 'alert-danger');

               // Check if any answer is selected
            let isAnswerSelected = false;
            form.querySelectorAll('input[name="selected_options[]"]').forEach(input => {
               if (input.checked) {
                  isAnswerSelected = true;
               }
            });
           if(isAnswerSelected){
             // Perform an AJAX request
             fetch("{{ route('submitQuestion') }}", {
               method: "POST",
               headers: {
                  "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
               },
               body: formData
            })
            .then(response => response.text()) // Use text() to inspect non-JSON responses
                     .then(data => {
                        console.log(data); // Log the raw response to see the actual content
                        try {
                           const jsonData = JSON.parse(data); // Parse the data
                           if (jsonData.success) {
                                 $(form.closest('.modal')).modal('hide');
                                 if (nextModalId) {
                                    $('#' + nextModalId).modal('show');
                                 }
                           } else {
                                 alert('Error: ' + (jsonData.message || 'Unable to submit the question.'));
                           }
                        } catch (error) {
                           console.error("Invalid JSON response:", error, data);
                        }
                     })
                     .catch(error => {
                        console.error('Error:', error);
                   });
           }else{
            event.preventDefault(); // This ensures no unintended behavior occurs
                // Show the error message if no option is selected
            errorSpan.textContent = 'Please select an option before submitting.';
            errorSpan.classList.add('alert', 'alert-danger'); // Add the alert and danger classes

              
            }
           
         });
      });
   });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.submit-nominee').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.nominee-form');
            const nextModalId = form.getAttribute('data-next-modal');
            const formData = new FormData(form);
            const errorSpan = form.querySelector('.error-message-nominee'); // Ensure the error span is specific to the form
               // Clear any previous error message
               errorSpan.textContent = '';
               errorSpan.classList.remove('alert', 'alert-danger');

               // Add status=1 to form data when submitting
            formData.append('status', 1);
            // Check if any of the required fields have values
            const firstName = formData.get('first_name');
            const lastName = formData.get('last_name');
            const emailAddress = formData.get('email_address');
            const phoneNumber = formData.get('phone_number');
            const relationship = formData.get('relationship');
      
            if (firstName || lastName || emailAddress || phoneNumber || relationship) {

               // Perform an AJAX request
               fetch("{{ route('submitNominee') }}", {
               method: "POST",
               headers: {
                  "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
               },
               body: formData
            })
            .then(response => response.text()) // Use text() to inspect non-JSON responses
                     .then(data => {
                        try {
                           const jsonData = JSON.parse(data); // Parse the data
                           if (jsonData.success) {
                                 $(form.closest('.modal')).modal('hide');
                                 if (nextModalId) {
                                    $('#' + nextModalId).modal('show');
                                 }
                           } else {
                                 alert('Error: ' + (jsonData.message || 'Unable to submit the question.'));
                           }
                        } catch (error) {
                           console.error("Invalid JSON response:", error, data);
                        }
                     })
                     .catch(error => {
                        console.error('Error:', error);
                   });
           }else{
            $(form.closest('.modal')).modal('hide');
            if (nextModalId) {
            $('#' + nextModalId).modal('show');
            }
            }
           
         });
      });
   });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.skip-nominee').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.nominee-form');
            const nextModalId = form.getAttribute('data-next-modal');
            const formData = new FormData(form);
            // Add status=0 to form data when skipping
            formData.append('status', 0);
            // Check if any of the required fields have values
            const firstName = formData.get('first_name');
            const lastName = formData.get('last_name');
            const emailAddress = formData.get('email_address');
            const phoneNumber = formData.get('phone_number');
            const relationship = formData.get('relationship');
            if (firstName || lastName || emailAddress || phoneNumber || relationship) {

            // Perform an AJAX request
            fetch("{{ route('submitNominee') }}", {
            method: "POST",
            headers: {
               "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
            })
            .then(response => response.text()) // Use text() to inspect non-JSON responses
                  .then(data => {
                     try {
                        const jsonData = JSON.parse(data); // Parse the data
                        if (jsonData.success) {
                              $(form.closest('.modal')).modal('hide');
                              if (nextModalId) {
                                 $('#' + nextModalId).modal('show');
                              }
                        } else {
                              alert('Error: ' + (jsonData.message || 'Unable to submit the question.'));
                        }
                     } catch (error) {
                        console.error("Invalid JSON response:", error, data);
                     }
                  })
                  .catch(error => {
                     console.error('Error:', error);
               });
            }else{
            $(form.closest('.modal')).modal('hide');
            if (nextModalId) {
            $('#' + nextModalId).modal('show');
            }
            }
           
         });
      });
   });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.submit-verification').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.verification-form');
            const nextModalId = form.getAttribute('data-next-modal');
            const formData = new FormData(form);
            const errorSpan = form.querySelector('.error-message-verify'); // Ensure the error span is specific to the form
               // Clear any previous error message
               errorSpan.textContent = '';
               errorSpan.classList.remove('alert', 'alert-danger');

            // Check if any of the required fields have values
            const mobileVerification = formData.get('mobile_number_verification');
            if (mobileVerification) {

               // Perform an AJAX request
               fetch("{{ route('submitVerification') }}", {
               method: "POST",
               headers: {
                  "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
               },
               body: formData
            })
            .then(response => response.text()) // Use text() to inspect non-JSON responses
                     .then(data => {
                        console.log(data); // Log the raw response to see the actual content
                        try {
                           const jsonData = JSON.parse(data); // Parse the data
                           if (jsonData.success) {
                                 $(form.closest('.modal')).modal('hide');
                                 if (nextModalId) {
                                    $('#' + nextModalId).modal('show');
                                 }
                           } else {
                                 alert('Error: ' + (jsonData.message || 'Unable to submit the question.'));
                           }
                        } catch (error) {
                           console.error("Invalid JSON response:", error, data);
                        }
                     })
                     .catch(error => {
                        console.error('Error:', error);
                   });
           }else{
            event.preventDefault(); // This ensures no unintended behavior occurs
                // Show the error message if no option is selected
            errorSpan.textContent = 'Please select an option before submitting.';
            errorSpan.classList.add('alert', 'alert-danger'); // Add the alert and danger classes

              
            }
           
         });
      });
   });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.skip-verification').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.verification-form');
            const nextModalId = form.getAttribute('data-next-modal');
             $(form.closest('.modal')).modal('hide');
             if (nextModalId) {
              $('#' + nextModalId).modal('show');
          }
           
         });
      });
   });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.submit-backup').forEach(button => {
         button.addEventListener('click', function (event) {
            const form = this.closest('.backup-form');
            const formData = new FormData(form);
            // Check if any of the required fields have values
            const backupEmail = formData.get('backup_email');
            if (backupEmail) {

               // Perform an AJAX request
               fetch("{{ route('submitVerification') }}", {
               method: "POST",
               headers: {
                  "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
               },
               body: formData
            })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  form.reset();
                  // Hide the current modal
                  $(form.closest('.modal')).modal('hide');
               
               } else {
                  alert('Error: ' + (data.message || 'Unable to submit the question.'));
               }
            })
            .catch(error => {
               console.error('Error:', error);
            });
            }else{
               $(form.closest('.modal')).modal('hide');
            }
            
         });
      });
   });
</script>

<!-- homeproperty functions starts from header_register_callback -->

<script>
   document.addEventListener('DOMContentLoaded', function () {
      console.log('DOM');
      const form = document.querySelector('.property-add-step-box');
      const continueButton = form.querySelector('.signup-btn');
      console.log(form);
      continueButton.addEventListener('click', function (event) {
         event.preventDefault(); // Prevent the default form submission

         // Get the selected radio button
         const selectedOption = form.querySelector('input[name="property-add-step"]:checked');
         if (selectedOption) {
            const selectedValue = selectedOption.value;
            // Redirect based on the selected radio button
            console.log("Selected ID:", selectedValue);

            // Define a mapping of selected values to URLs
            const urlMapping = {
                "1": "{{ route('step2') }}",  // Example: Asset ID 1 goes to step2
                "2": "/other-real-estate-page-url",
                "3": "/vehicles-page-url",
                "4": "/safe-deposit-boxes-page-url",
                "5": "/home-safes-page-url",
                "6": "/important-possessions-page-url"
            };
            // Get the URL for the selected option
            const targetUrl = urlMapping[selectedValue] || "{{ route('home-property') }}"; // Default to step2 if no match

            // Redirect with selected_id as a query parameter
            window.location.href = targetUrl + "?selected_id=" + encodeURIComponent(selectedValue);
         } else {
            alert('Please select an option before continuing.');
         }
      });
   });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('country').addEventListener('change', function () {
        var countryId = this.value;
        var stateDropdown = document.getElementById('state');

        // Clear previous options
        stateDropdown.innerHTML = '<option value="">Select an option</option>';

        if (countryId) {
            fetch('/get-states/' + countryId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(state => {
                        var option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        stateDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));
        }
    });
});
</script>

<script>
    function updateLabel() {
        // Get the selected option
        var select = document.getElementById("select-document");
        var selectedOption = select.options[select.selectedIndex];
        
         // Get the document name from data attribute
         var documentName = selectedOption.getAttribute("data-name");
         if(documentName){
         // Update the label text
         document.getElementById("document-label").innerText = documentName + " Number";
         document.getElementById("location-document-label").innerText ="Location of the item - Your "+ documentName;
        }else{
         document.getElementById("document-label").innerText = "Document Number";
         document.getElementById("location-document-label").innerText ="Location of the item - Your Document";
        }
        
    }
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
   var backupEmail = document.getElementById('backupEmail');
   console.log(backupEmail.value);
   // Check if the element exists before accessing its value
   if (backupEmail && backupEmail.value === undefined) {
      console.log(backupEmail.value);
      var myModal = new bootstrap.Modal(document.getElementById('onboardStep1Modal'));
      myModal.show();
   }
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
   const form = document.getElementById("profile-form");

   form.addEventListener("submit", function (e) {
      e.preventDefault();

      let isValid = true;

      // Document Type Validation
      const document_type = document.getElementById("select-document");
      const documentTypeError = document.getElementById("documentTypeError");
      if (document_type.value === "") {
         documentTypeError.innerText = "Please select a document type.";
         isValid = false;
      } else {
         documentTypeError.innerText = "";
      }

      // Document Number Validation
      const document_number = document.getElementById("license-num");
      const documentNumberError = document.getElementById("documentNumberError");
      const documentNumberPattern = /^\d{16}$/;
      if (!documentNumberPattern.test(document_number.value.trim())) {
         documentNumberError.innerText = "Please enter a valid 16-digit document number.";
         isValid = false;
      } else {
         documentNumberError.innerText = "";
      }

      // Expire Date Validation
      const expire_date = document.getElementById("expire-date");
      const expireDateError = document.getElementById("expireDateError");
      if (expire_date.value && new Date(expire_date.value) < new Date()) {
         expireDateError.innerText = "Expire date cannot be in the past.";
         isValid = false;
      } else {
         expireDateError.innerText = "";
      }

      // Location Validation
      const location = document.getElementById("location");
      const locationError = document.getElementById("locationError");
      if (location.value.trim() === "") {
         locationError.innerText = "Please enter the location.";
         isValid = false;
      } else {
         locationError.innerText = "";
      }

      // File Upload Validation
      const fileInput = document.getElementById("upload");
      const uploadError = document.getElementById("uploadError");
      if (fileInput.files.length === 0) {
         uploadError.innerText = "Please upload your diving license scan copy.";
         isValid = false;
      } else {
         const file = fileInput.files[0];
         const allowedTypes = ["image/jpeg", "image/png"];

         if (!allowedTypes.includes(file.type)) {
            uploadError.innerText = "Only JPG, JPEG, and PNG files are allowed.";
            isValid = false;
         } else if (file.size > 2 * 1024 * 1024) {
            uploadError.innerText = "File size should not exceed 2MB.";
            isValid = false;
         } else {
            uploadError.innerText = "";
         }
      }

      if (isValid) {
         const formData = new FormData(form);

         fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
               "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            },
         })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  window.location.href = "/personal-info/view";
               } else {
                  alert("Something went wrong, please try again.");
               }
            })
            .catch(error => {
               console.error("Error:", error);
            });
      }
   });
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
   const successMsgBox = document.querySelector(".success-msg-box");
   const dashboardTitle = document.querySelector(".dasboard-title");
   const closeButton = document.querySelector(".close-icon");

   // Initially show the success message
   successMsgBox.style.display = "block";
   dashboardTitle.style.display = "none";

   // Add click event on the close button
   closeButton.addEventListener("click", function () {
      successMsgBox.classList.add("hide-message");
      setTimeout(() => {
         successMsgBox.setAttribute("style", "display: none !important;");// Completely remove the element after animation
         dashboardTitle.style.display = "block"; // Show the next div
      }, 300); // Duration matches the transition time
   });
   // Function to hide the message and show the next div
   function hideMessage() {
      successMsgBox.classList.add("hide-message"); // Add animation class
      setTimeout(() => {
         successMsgBox.setAttribute("style", "display: none !important;"); // Hide the element
         dashboardTitle.style.display = "block"; // Show the next div
      }, 300); // Duration matches the animation time
   }

   // Automatically hide message after 3 seconds
   const autoHide = setTimeout(hideMessage, 9000);

   // Add click event on the close button
   closeButton.addEventListener("click", function () {
      clearTimeout(autoHide); // Cancel auto hide if user clicks close button
      hideMessage();
   });
});

</script>