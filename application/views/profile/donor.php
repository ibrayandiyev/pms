<?php $disabled = (is_admin_loggedin() ?  '' : 'disabled'); ?>
<div class="row">
	<div class="col-md-12 mb-lg">
		<div class="profile-head social">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="image-content-center user-pro">
					<div class="preview">
						<ul class="social-icon-one">
							<li>DONOR</li>
						</ul>
						<img src="<?=get_image_url('donor', $donor['photo'])?>">
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-5 col-xl-5">
				<h5><?=html_escape($donor['name'])?></h5>
				<p><?=ucfirst('donor')?></p>
				<ul>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Email"><i class="far fa-envelope"></i></div> <?=html_escape($donor['email'])?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Phone"><i class="fas fa-phone"></i></div> <?=html_escape(empty($donor['phone']) ? 'N/A' : $donor['phone']);?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Country"><i class="fas fa-home"></i></div> <?=html_escape(!empty($donor['country_name']) ? $donor['country_name'] : 'N/A'); ?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Joining Date"><i class="fas fa-calendar"></i></div> <?=html_escape($donor['joining_date'])?></li>
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
						<input type="hidden" name="donor_id" id="donor_id" value="<?php echo $donor['id']; ?>">
						<!-- employee details -->
						<div class="headers-line mt-md">
							<i class="fas fa-user-check"></i> Donor Detail
						</div>
						<!-- donor details -->
						<div class="row">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Name <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input class="form-control" name="name" type="text" value="<?=set_value('name', $donor['name'])?>" autocomplete="off" />
									</div>
									<span class="error"><?php echo form_error('name'); ?></span>
								</div>
							</div>
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Email <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
										<input type="text" class="form-control" name="email" id="email" value="<?=set_value('email', $donor['email'])?>" autocomplete="off" />
									</div>
									<span class="error"><?php echo form_error('email'); ?></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Phone </label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
										<input type="text" class="form-control" name="phone" value="<?=set_value('phone', $donor['phone'])?>" autocomplete="off" />
									</div>
									<span class="error"><?php echo form_error('phone'); ?></span>
								</div>
							</div>
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label">Country </label>
									<?php
										$countryNameList = $this->app_lib->getCountryList();
										echo form_dropdown("country_name", $countryNameList, $donor['country_name'], "class='form-control' id='country_name'
										data-plugin-selectTwo data-width='100%'");
									?>
									<span class="error"><?php echo form_error('country_name'); ?></span>
								</div>
							</div>
						</div>		
						<div class="row mb-md">
							<div class="col-md-12">
								<div class="form-group">
									<label for="input-file-now">Profile Picture</label>
									<input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('donor', $donor['photo'])?>"/>
									<span class="error"><?php echo form_error('user_photo'); ?></span>
								</div>
							</div>
							<input type="hidden" name="old_user_photo" value="<?=html_escape($donor['photo'])?>">
						</div>

						<!-- login details -->
						<div class="headers-line">
							<i class="fas fa-user-lock"></i> Login Details
						</div>

						<div class="row mb-lg">
							<div class="col-md-12 mb-sm">
								<div class="form-group">
									<label class="control-label">Username <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input type="text" class="form-control" name="username" id="username" value="<?=set_value('username', html_escape($donor['username']))?>" />
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
