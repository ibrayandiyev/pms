<header class="header">
	<div class="logo-env">
		<a href="<?php echo base_url('dashboard');?>" class="logo">
			<img src="<?php echo base_url('uploads/app_image/logo-small.png');?>" height="40">
		</a>

		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="header-left hidden-xs">
		<ul class="header-menu">
			<!-- sidebar toggle button -->
			<li>
				<div class="header-menu-icon sidebar-toggle" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
					<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</li>
			<!-- full screen button -->
			<li>
				<div class="header-menu-icon s-expand">
					<i class="fas fa-expand"></i>
				</div>
			</li>
			<!-- shortcut box -->
			<!-- <li>
				<div class="header-menu-icon dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-th"></i>
				</div>
				<div class="dropdown-menu header-menubox qk-menu">
					<div class="qk-menu-p">
						<div class="menu-icon-grid">
							<a href="<?php echo base_url('employee/view');?>"><i class="fas fa-users"></i> Employee</a>
							<a href="<?php echo base_url('administrators/view'); ?>"><i class="fas fa-user"></i> Administrators</a>
							<a href="<?php echo base_url('supervisors/view');?>"><i class="fas fa-user"></i> Supervisor</a>
							<a href="<?php echo base_url('donors/view');?>"><i class="fas fa-user"></i> Donor</a>
						</div>
					</div>
				</div>
			</li> -->
		</ul>
	</div>

	<div class="header-right">
		<ul class="header-menu">
		</ul>

		<!-- user profile box -->
		<span class="separator"></span>
		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
					<img src="<?php echo get_image_url(get_loggedin_user_type(), $this->session->userdata('logger_photo'));?>" alt="user-image" class="img-circle" height="35">
				</figure>
			</a>
			<div class="dropdown-menu">
				<ul class="dropdown-user list-unstyled">
					<li class="user-p-box">
						<div class="dw-user-box">
							<div class="u-img">
								<img src="<?php echo get_image_url(get_loggedin_user_type(), $this->session->userdata('logger_photo'));?>" alt="user">
							</div>
							<div class="u-text">
								<h4><?php echo $this->session->userdata('name');?></h4>
								<p class="text-muted"><?php echo ucfirst(loggedin_role_name());?></p>
								<a href="<?php echo base_url('authentication/logout'); ?>" class="btn btn-danger btn-xs"><i class="fas fa-sign-out-alt"></i> Logout</a>
							</div>
						</div>
					</li>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo base_url('profile');?>"><i class="fas fa-user-shield"></i> Profile</a></li>
					<li><a href="<?php echo base_url('profile/password');?>"><i class="fas fa-mars-stroke-h"></i> Reset Pssword</a></li>
					<?php if (is_superadmin_loggedin()): ?>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo base_url('settings/universal');?>"><i class="fas fa-toolbox"></i> Globla Settings</a></li>
					<?php endif; ?>
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo base_url('authentication/logout');?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>