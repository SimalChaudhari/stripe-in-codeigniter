<!doctype html>
<html>
<head>
    <title><?php echo isset($title) ? $title : 'User Tracking'; ?></title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css'>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;1,100;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custome.css') ?>">
 
</head>
<body>
<div class="wrap login_page signup">
    <h2>Login</h2>
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
    <form method="post" id="loginForm">
        <div class="name">
            <div class='label' for="email">Email: <span>*</span></div>
            <input placeholder="admin@gmail.com" id="email" name="email" type="text" autofocus />
        </div>
        <div class="name">
            <div class='label' for="password">Password: <span>*</span></div>
            <input type="password" title="Please enter your password" placeholder="******" value="" name="password" id="password" />
        </div>
        <div class="sumnit_div">
            <input type="submit" value="Login"/>
        </div>
    </form>
    <br />
    <p class="tip signup-tip">
        <span>Don't have an account?</span>
        <a href="<?php echo base_url('signup'); ?>">Sign up</a>
    </p>
</div>
</body>
</html>

<script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?> "></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>

<script type="text/javascript">
$(document).ready(function(){
  console.log('hi');
    $('#loginForm').validate(
    {
        rules:
        {
         "email":{required:true,email:true},
         "password":{required:true,}
        },
        messages:
        {
            "email":{required:"This field is required",email:"Please enter a valid E-mail"},
            "password":{required:"This field is required"}
        },
        submitHandler: function (form) 
        {
            $('button[type="submit"]').attr('disabled', true);
            $('.alert').hide();
            form.submit();
        },
    });
});

// setTimeout(function(){ $('.alert').hide() }, 3000);
</script> 