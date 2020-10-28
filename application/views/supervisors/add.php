<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open_multipart($this->uri->uri_string()); ?>
			<header class="panel-heading">
				<h4 class="panel-title">
					<i class="far fa-user-circle"></i> Add Supervisor
				</h4>
			</header>
			<div class="panel-body">
				<!-- supervisor details -->
				<div class="headers-line mt-md">
					<i class="fas fa-user-check"></i> Supervisor Detail
				</div>

				<div class="row">
					<div class="col-md-5 mb-sm">
						<div class="form-group">
							<label class="control-label">Name <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-user"></i></span>
								<input class="form-control" name="name" type="text" value="<?=set_value('name')?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('name'); ?></span>
						</div>
					</div>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label">Email <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
								<input type="text" class="form-control" name="email" id="email" value="<?=set_value('email')?>" autocomplete="off" />
							</div>
							<span class="error"><?php echo form_error('email'); ?></span>
						</div>
					</div>
                    <div class="col-md-3 mb-sm">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label">Joining Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="text" class="form-control" name="joining_date" data-plugin-datepicker data-plugin-options='{ "todayHighlight" : true }'
                                    autocomplete="off" value="<?=set_value('joining_date')?>" />
                                </div>
                                <span class="error"><?php echo form_error('joining_date'); ?></span>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
					<div class="col-md-12 mb-sm">
						<div class="form-group">
							<label class="control-label">Profile Picture</label>
							<input type="file" name="user_photo" class="dropify" />
							<span class="error"><?php echo form_error('user_photo'); ?></span>
						</div>
					</div>
				</div>
				<div id="grdLogin">
					<!-- login details -->
					<div class="headers-line mt-md">
						<i class="fas fa-user-lock"></i> Login Details
					</div>

					<div class="row mb-lg">
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label">Username <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-user"></i></span>
									<input type="text" class="form-control" name="username" value="<?=set_value('username')?>" autocomplete="off" />
								</div>
								<span class="error"><?php echo form_error('username'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label">Password <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="password" value="<?=set_value('password')?>" />
								</div>
								<span class="error"><?php echo form_error('password'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label">Retype Password <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="retype_password" value="<?=set_value('retype_password')?>" />
								</div>
								<span class="error"><?php echo form_error('retype_password'); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="submit" value="save" class="btn btn btn-default btn-block">
							<i class="fas fa-plus-circle"></i> Save
						</button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>
