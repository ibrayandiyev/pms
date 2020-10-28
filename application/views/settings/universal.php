<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li <?=(empty($this->session->flashdata('active')) ? 'class="active"' : '');?>>
				<a href="#setting" data-toggle="tab">
					<i class="fas fa-chalkboard-teacher"></i> 
				   <span class="hidden-xs">General Settings</span>
				</a>
			
			</li>
			<li <?=($this->session->flashdata('active') == 3 ? 'class="active"' : '');?>>
				<a href="#upload" data-toggle="tab">
				   <i class="fab fa-uikit"></i>
				   <span class="hidden-xs"> Logo</span>
				</a>
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane box <?=(empty($this->session->flashdata('active')) ? 'active' : '');?>" id="setting">
				<?php echo form_open($this->uri->uri_string(), array( 'class' 	=> 'validate form-horizontal form-bordered' )); ?>
				<div class="form-group">
					<label class="col-md-3 control-label">System Name</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="system_name" value="<?=set_value('system_name', $global_config['system_name'])?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Phone No</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="phone" value="<?=set_value('phone', $global_config['phone'])?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Address</label>
					<div class="col-md-6">
						<textarea name="address" rows="2" class="form-control" aria-required="true"><?=set_value('address', $global_config['address'])?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Timezone</label>
					<div class="col-md-6">
						<?php
						$timezones = $this->app_lib->timezone_list();
						echo form_dropdown("timezone", $timezones, set_value('timezone', $global_config['timezone']), "class='form-control populate' required id='timezones' 
						data-plugin-selectTwo data-width='100%'");
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Date Format</label>
					<div class="col-md-6">
						<?php
						$getDateformat = $this->app_lib->getDateformat();
						echo form_dropdown("date_format", $getDateformat, set_value('date_format', $global_config['date_format']), "class='form-control' id='date_format' 
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Footer Text</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="footer_text" value="<?=set_value('footer_text', $global_config['footer_text'])?>" />
					</div>
				</div>

				<footer class="panel-footer mt-lg">
					<div class="row">
						<div class="col-md-2 col-sm-offset-3">
							<button type="submit" class="btn btn btn-default btn-block" name="submit" value="setting">
								<i class="fas fa-plus-circle"></i> Save
							</button>
						</div>
					</div>
				</footer>
				<?php echo form_close(); ?>
			</div>

			<div class="tab-pane box <?=($this->session->flashdata('active') == 3 ? 'active' : '');?>" id="upload">
				<?php
					echo form_open_multipart($this->uri->uri_string(), array('class' 	=> 'validate'));
				?>

				<!-- all logo -->
				<div class="headers-line">
					<i class="fab fa-envira"></i> Logo
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">System Logo</label>
							<input type="file" name="logo_file" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=base_url('uploads/app_image/logo.png')?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Text Logo</label>
							<input type="file" name="text_logo" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=base_url('uploads/app_image/logo-small.png')?>" />
						</div>
					</div>
				</div>

				<!-- login background -->
				<div class="headers-line mt-lg">
					<i class="fas fa-sign-out-alt"></i> Login Background
				</div>
				<div class="row mb-ld">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Slider 1</label>
							<input type="file" name="slider_1" class="dropify" data-allowed-file-extensions="jpg" data-default-file="<?=base_url('uploads/login_image/slider_1.jpg')?>" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Slider 2</label>
							<input type="file" name="slider_2" class="dropify" data-allowed-file-extensions="jpg" data-default-file="<?=base_url('uploads/login_image/slider_2.jpg')?>" />
						</div>
					</div>
					<div class="col-md-4 mb-lg">
						<div class="form-group">
							<label class="control-label">Slider 3</label>
							<input type="file" name="slider_3" class="dropify" data-allowed-file-extensions="jpg" data-default-file="<?=base_url('uploads/login_image/slider_3.jpg')?>" />
						</div>
					</div>
				</div>
				
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-sm-offset-10">
							<button type="submit" class="btn btn btn-default btn-block" name="submit" value="logo">
								<i class="fas fa-upload"></i> upload
							</button>
						</div>
					</div>
				</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>