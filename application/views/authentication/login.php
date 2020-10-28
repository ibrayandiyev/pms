<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <meta name="keywords" content="">
    <meta name="description" content="Project Management System">
    <meta name="author" content="Ibragim Yandiyev">
    <title>Login</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.png');?>">
    
    <!-- Web Fonts  -->
	<link href="<?php echo is_secure('fonts.googleapis.com/css?family=Signika:300,400,600,700');?>" rel="stylesheet"> 
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css'); ?>">
	<script src="<?php echo base_url('assets/vendor/jquery/jquery.js');?>"></script>
	
	<!-- sweetalert js/css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert-custom.css');?>">
	<script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert.min.js');?>"></script>
	<!-- login page style css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/login_page/css/style.css');?>">
	<script type="text/javascript">
		var base_url = '<?php echo base_url() ?>';
	</script>
</head>
<body>
<!-- <body oncontextmenu="return false;" ondragstart="return false;"> -->
    <div class="auth-main">
        <div class="container">
            <div class="slideIn">

                <!-- Login Right Side -->
                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12 no-padding fitxt-center">
                    <div class="image-area">
                        <div class="content">
                            <div class="image-hader">
                                <h2>Welcome To</h2>
                            </div>
                            <div class="center img-hol-p">
                                <img src="<?php echo base_url('uploads/app_image/logo.png');?>" height="60" alt="techtune School">
                            </div>
                            <div class="address">
                                <p><?php echo $global_config['address']; ?></p>
                            </div>			
                            <div class="phone">
                                <i class="fa fa-phone"></i><span><?php echo $global_config['phone']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login -->
                <div class="col-lg-6 col-lg-offset-right-1 col-md-6 col-md-offset-right-1 col-sm-12 col-xs-12 no-padding">
                    <div class="sign-area">
                        <div class="sign-hader">
                            <img src="<?php echo base_url('uploads/app_image/logo.png');?>" height="54" alt="">
                                <h2><?php echo $global_config['system_name'];?></h2>
                        </div>
                        <?php echo form_open($this->uri->uri_string()); ?>
                            <div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon">
                                            <i class="far fa-user"></i>
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" name="email" value="<?php echo set_value('email');?>" placeholder="Username" />
                                </div>
                                <span class="error"><?php echo form_error('email'); ?></span>
                            </div>
                            <div class="form-group <?php if (form_error('password')) echo 'has-error'; ?>">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fas fa-unlock-alt"></i></span>
                                    </span>
                                    <input type="password" class="form-control input-rounded" name="password" placeholder="Password" />
                                </div>
                                <span class="error"><?php echo form_error('password'); ?></span>
                            </div>

                            <div class="forgot-text">
                                <div class="checkbox-replace">
                                <label class="i-checks"><input type="checkbox" name="remember" id="remember"><i></i> Remember me</label>
                                </div>
                                <!-- <div class="">
                                    <a href="<?php //echo base_url('authentication/forgot');?>">Forgot Your Password?</a>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <button type="submit" id="btn_submit" class="btn btn-block btn-round">
                                    <i class="fas fa-sign-in-alt"></i> Login</button>
                            </div>
                            <div class="sign-footer">
                            <p><?php echo $global_config['footer_text'];?></p>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
        }
    </script>

    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js');?>"></script>
    <script src="<?php echo base_url('assets/vendor/jquery-placeholder/jquery-placeholder.js');?>"></script>
    <!-- backstretch js -->
    <script src="<?php echo base_url('assets/login_page/js/jquery.backstretch.min.js');?>"></script>
    <script src="<?php echo base_url('assets/login_page/js/custom.js');?>"></script>

    <?php
    $alertclass = "";
    if($this->session->flashdata('alert-message-success')){
        $alertclass = "success";
    } else if ($this->session->flashdata('alert-message-error')){
        $alertclass = "error";
    } else if ($this->session->flashdata('alert-message-info')){
        $alertclass = "info";
    }
    if($alertclass != ''):
        $alert_message = $this->session->flashdata('alert-message-'. $alertclass);
    ?>
        <script type="text/javascript">
            swal({
                toast: true,
                position: 'top-end',
                type: '<?php echo $alertclass;?>',
                title: '<?php echo $alert_message;?>',
                confirmButtonClass: 'btn btn-default',
                buttonsStyling: false,
                timer: 8000
            })
        </script>
    <?php endif; ?>
</body>
</html>