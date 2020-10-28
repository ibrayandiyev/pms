<div class="row">
	<div class="col-md-12 mb-lg">
		<div class="profile-head social">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="image-content-center user-pro">
					<div class="preview">
					<div class="preview">
						<ul class="social-icon-one">
							<li><?php if (is_superadmin_loggedin()){ ?> SUPER ADMINISTRATOR <?php } else { ?> ADMINISTRATOR <?php } ?></li>
						</ul>
						<img src="<?=get_image_url('admin', $admin['photo'])?>">
					</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-5 col-xl-5">
				<h5><?=html_escape($admin['name'])?></h5>
				<p><?=ucfirst('administrator')?></p>
				<ul>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Email"><i class="far fa-envelope"></i></div> <?=html_escape($admin['email'])?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Joining Date"><i class="fas fa-calendar"></i></div> <?=html_escape($admin['joining_date'])?></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> Profile</h4>
			</header>
            <?php echo form_open_multipart($this->uri->uri_string()); ?>
				<div class="panel-body">
					<fieldset>
						<input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>" id="admin_id">
						<!-- admin details -->
						<div class="headers-line mt-md">
							<i class="fas fa-user-check"></i> <?php if (is_superadmin_loggedin()){ ?> Super Administrator Details <?php } else { ?> Administrator Details <?php } ?>
						</div>
						<div class="row">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Name <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input class="form-control" name="name" type="text" value="<?=set_value('name', $admin['name'])?>" />
									</div>
									<span class="error"><?php echo form_error('name'); ?></span>
								</div>
							</div>
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Email <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
										<input type="text" class="form-control" name="email" id="email" value="<?=set_value('email', html_escape($admin['email']))?>" />
									</div>
									<span class="error"><?php echo form_error('email'); ?></span>
								</div>
							</div>
						</div>
						
						<div class="row mb-md">
							<div class="col-md-12">
								<div class="form-group">
									<label for="input-file-now">Profile Picture</label>
									<input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('admin', $admin['photo'])?>"/>
									<span class="error"><?php echo form_error('user_photo'); ?></span>
								</div>
							</div>
							<input type="hidden" name="old_user_photo" value="<?=html_escape($admin['photo'])?>">
						</div>

						<!-- login details -->
						<div class="headers-line">
							<i class="fas fa-user-lock"></i> Login Detail
						</div>

						<div class="row mb-lg">
							<div class="col-md-12 mb-sm">
								<div class="form-group">
									<label class="control-label">Username <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input type="text" class="form-control" name="username" id="username" value="<?=set_value('username', html_escape($admin['username']))?>" />
									</div>
									<span class="error"><?php echo form_error('username'); ?></span>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-9 col-md-3">
							<button class="btn btn-default btn-block" type="submit"><i class="fas fa-plus-circle"></i> Update</button>
						</div>	
					</div>
				</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
