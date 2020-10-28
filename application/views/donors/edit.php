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
	<div class="panel-group" id="accordion">
	<div class="panel panel-accordion">
		<div class="panel-heading">
			<h4 class="panel-title">
				<div class="pull-right mt-hs">
					<button class="btn btn-default btn-circle" id="authentication_btn">
						<i class="fas fa-unlock-alt"></i> Authentication
					</button>
				</div>
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#profile">
					<i class="fas fa-user-edit"></i> Donor Details
				</a>
			</h4>
		</div>
		<div id="profile" class="accordion-body">
			<?php echo form_open_multipart($this->uri->uri_string()); ?>
			<input type="hidden" name="donor_id" value="<?php echo $donor['id']; ?>" id="donor_id">
			<div class="panel-body">
				<!-- donor details -->
				<div class="row">
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label">Name <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-user"></i></span>
								<input class="form-control" name="name" type="text" value="<?=set_value('name', $donor['name'])?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('name'); ?></span>
						</div>
					</div>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label">Email <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
								<input type="text" class="form-control" name="email" id="email" value="<?=set_value('email', $donor['email'])?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('email'); ?></span>
						</div>
					</div>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label">Phone </label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
								<input type="text" class="form-control" name="phone" value="<?=set_value('phone', $donor['phone'])?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('phone'); ?></span>
						</div>
					</div>
				</div>
				<div class="row">
                    <div class="col-md-5 mb-sm">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea name="description" rows="2" class="form-control" aria-required="true"><?=set_value('description', $donor['description'])?></textarea>
							<span class="error"><?php echo form_error('description'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-sm">
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
                    <div class="col-md-3 mb-sm">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label">Joining Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="text" class="form-control" name="joining_date" data-plugin-datepicker data-plugin-options='{ "todayHighlight" : true }'
                                    autocomplete="off" value="<?=set_value('joining_date', $donor['joining_date'])?>" />
                                </div>
                                <span class="error"><?php echo form_error('joining_date'); ?></span>
                            </div>
                        </div>
                    </div>
				</div>

				<div class="row mb-md">
					<div class="col-md-12 mb-sm">
						<div class="form-group">
							<label class="control-label">Profile Picture </label>
							<input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('donor', $donor['photo'])?>" />
						</div>
						<span class="error"><?php echo form_error('user_photo'); ?></span>
					</div>
					<input type="hidden" name="old_user_photo" value="<?=$donor['photo']?>">
				</div>

				<!-- login details -->
				<div class="headers-line">
					<i class="fas fa-user-lock"></i> Login Detail Information
				</div>

				<div class="row mb-lg">
					<div class="col-md-12 mb-sm">
						<div class="form-group">
							<label class="control-label">Username <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-user"></i></span>
								<input type="text" class="form-control" name="username" value="<?=set_value('username', $donor['username'])?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('username'); ?></span>
						</div>
					</div>
				</div>

			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-9 col-md-3">
						<button type="submit" name="update" value="1" class="btn btn-default btn-block">Update</button>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- login authentication and account inactive modal -->
<div id="authentication_modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-unlock-alt"></i> Authentication
			</h4>
		</header>
		<?php echo form_open('donors/change_password', array('class' => 'frm-submit')); ?>
        <div class="panel-body">
        	<input type="hidden" name="donor_id" value="<?=$donor['id']?>">
            <div class="form-group">
	            <label for="password" class="control-label">Password <span class="required">*</span></label>
	            <div class="input-group">
	                <input type="password" class="form-control password" name="password" autocomplete="off" />
	                <span class="input-group-addon">
	                    <a href="javascript:void(0);" id="showPassword" ><i class="fas fa-eye"></i></a>
	                </span>
	            </div>
	            <span class="error"></span>
                <div class="checkbox-replace mt-lg">
                    <label class="i-checks">
                        <input type="checkbox" name="authentication" id="cb_authentication">
                        <i></i> Login Authentication Deactivate
                    </label>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="text-right">
                <button type="submit" class="btn btn-default mr-xs" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Update</button>
                <button class="btn btn-default modal-dismiss">Close</button>
            </div>
        </footer>
        <?php echo form_close(); ?>
	</section>
</div>

<script type="text/javascript">
	var authenStatus = "<?=$donor['active']?>";
</script>
