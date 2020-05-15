<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;1,100;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custome.css') ?>">
</head>
<body>
   
    <div class="wrap login_page signup">
        <h2>Signup</h2>
        <?php
            if (isset($error) && !empty($error)) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            if ($this->session->flashdata('success')) {
                echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
            }
            if ($this->session->flashdata('error')) {
                echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
            }
        ?>
        <form method="post" id="signupForm" action="">
            <div class="name form-group">
                <div class='label' for="username">Name<span class="required-field">*</span></div>
                <input placeholder="Name" id="username" name="username" type="text" autofocus />
            </div>
            <div class="name form-group">
                <div class='label' for="email">Email<span class="required-field">*</span></div>
                <input placeholder="admin@gmail.com" id="email" name="email" type="text" autofocus />
            </div>
            <div class="form_field form_field_set">
                <div class="Username">
                    <div class='label' for="password">Password<span class="required-field">*</span></div>
                    <input placeholder="Password" class="signup-password" id="password" name="password" type="password" autofocus />
                </div>
                <div class="Password">
                    <div class='label' for="confirm_password">Confirm Password<span class="required-field">*</span></div>
                    <input placeholder="Confirm password" class="signup-password" id="confirm_password" name="confirm_password" type="password"  />
                </div>
            </div>
            <div class="name">
                <div class='label' for="phone">Phone</div>
                <input placeholder="Option - If you want free consultation" id="phone" name="phone" type="text" autofocus />
            </div>
            <div class="name">
                <div class='label' for="plan">Choose your plan<span class="required-field">*</span></div>
                <select id="plan" name="plan">
                    <option value="">Select Plan</option>
                    <?php if(!empty($plans)) {
                            foreach ($plans as $plan) {
                    ?>
                                <option value="<?php echo isset($plan->name) ? $plan->name : ''?>"><?php echo isset($plan->name) ? $plan->name : ''?> ($<?php echo isset($plan->price) ? $plan->price : 0?>/month)</option>
                    <?php
                            }
                        }
                    ?>
                </select>
                <p class="sub_text">Your account is automatically charged when the 14 days free is completed. cancel anytime.</p>
            </div>
            
            <div class="name card-data">
                <div class='label' for="name_of_card">Name On Card<span class="required-field">*</span></div>
                <input placeholder="Jane Deo" id="name_of_card" name="name_of_card" type="text" autofocus />
            </div>
            <div class="name card-data">
                <div class='label' for="card-element">Credit or debit card<span class="required-field">*</span></div>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>
            <div class="name zip_code card-data">
                <div class='label' for="zip_code">Zip Code<span class="required-field">*</span></div>
                <input placeholder="94110" type="number" id="zip_code" name="zip_code" autofocus />
            </div>
            <div class="sumnit_div">
              <!-- <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input term-condition" name="termsConditions" id="termsConditions">
                <label class="custom-control-label" for="customCheck1">I accept the <span>Terms and condition</span></label>
                <br/><label id="termsConditions-error" class="error" for="termsConditions">You must agree to the terms and conditions before registering!.</label>
              </div> -->
            </div>
              <input type="submit" value="signup"/>
            </div>  
        </form>
        <br />
        <footer class="text-center" style="margin-top: -151px;">
            <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">Already have an account?  <a href="<?php echo base_url('login'); ?>"  class="g-font-weight-600">Login</a></p>
        </footer>
    </div>
</body>
</html>

<script src="<?php echo base_url('assets/js/jquery.min.js') ?> "></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?> "></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo base_url('assets/js/jquery.caret.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.mobilePhoneNumber.js') ?>"></script>

<script type="text/javascript">
    var elements, form, stripe, card;
    $(document).on('ready', function () {
        $('.card-data,#termsConditions-error').hide(); 
        $('input[name=phone]').mobilePhoneNumber();
        stripe = Stripe("<?php echo PUBLISHABLE_KEY; ?>");
        elements = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: '#F99A52',
                        color: '#32315E',
                        lineHeight: '48px',
                        fontWeight: 400,
                        fontFamily: '"Helvetica Neue", "Helvetica", sans-serif',
                        fontSize: '15px',
                        '::placeholder': {
                            color: '#333333',
                        }
                    },
                }
            }); 
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        $('#signupForm').validate({
            rules:{
                "username":{required:true},
                "email":{
                    required:true,
                    email:true,
                    remote: {
                    url: '<?php echo base_url('signup/checkUniqueEmail'); ?>',
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        }
                    },
                }},
                "password":{required:true,minlength : 6},
                "confirm_password":{required:true, minlength : 6,equalTo : "#password"}
            }, messages:{
                "email":{required:"This field is required",email:"Please enter a valid E-mail",remote: "The email is already registered."},
            },
            submitHandler: function (form) {
                $('input[type="submit"]').attr('disabled', true);
                $('.alert').hide();
                event.preventDefault();
                if ($('#plan').val() != 'Free' && $('#plan').val() != '') {
                    var extraDetails = {
                        name: form.querySelector('input[name=name_of_card]').value,
                        address_zip: form.querySelector('input[name=zip_code]').value
                    };
                    stripe.createToken(card, extraDetails).then(function(result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            stripeTokenHandler(result.token);
                        }
                    });
                } else {
                    form.submit();
                    // if (!$('#termsConditions').is(':checked') ) {
                    //     $('#termsConditions-error').show();
                    //     $('#termsConditions-error').html("You must agree to the terms and conditions before registering!.");
                    // }else{
                    //     $('#termsConditions-error').hide();
                    //     form.submit();
                    // }
                }
            },
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('signupForm');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }

        // Handle Choose Plan
        $('#plan').on('change',function(event) {
            if ($('#plan').val() != 'Free' && $('#plan').val() != '') {
                $('.card-data').show();
            } else {
                $('.card-data').hide();
            }
        });

        $('#termsConditions').on( "click",function(event) {
            if($(this).prop("checked") == true){
                $('#termsConditions-error').hide()
            }else if($(this).prop("checked") == false){
                $('#termsConditions-error').show();
                $('#termsConditions-error').html("You must agree to the terms and conditions before registering!.");
            }
        });
    });
    setTimeout(function(){ $('.alert').hide() }, 3000);
</script> 
