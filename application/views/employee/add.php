<div class="row">
	<div class="col-md-12">
		<section class="panel">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="far fa-user-circle"></i> Add Employee
					</h4>
				</div>
			<?php echo form_open_multipart($this->uri->uri_string()); ?>
				<div class="panel-body">
					<!-- academic details-->
					<div class="headers-line mt-md">
					</div>
					<div class="row">
						<div class="col-md-5 mb-sm">
							<div class="form-group">
								<label class="control-label">Employee ID</label>
								<input type="text" class="form-control" name="" value="<?=set_value('employee_id', $employee_id)?>"  disabled="disabled">
								<input type="hidden" name="employee_id" value="<?=set_value('employee_id', $employee_id)?>">
							</div>
							<span class="error"><?php echo form_error('employee_id'); ?></span>
						</div>
						<div class="col-md-7 mb-sm">
							<div class="form-group">
								<label class="control-label">Employee NO <span class="required">*</span></label>
								<input type="text" class="form-control" name="employee_no" value="<?=set_value('employee_no')?>">
							</div>
							<span class="error"><?php echo form_error('employee_no'); ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 mb-sm">
							<div class="form-group">
								<label class="control-label">Name <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-user"></i></span>
									<input type="text" class="form-control" name="name" value="<?=set_value('name')?>" autocomplete="off" />
								</div>
								<span class="error"><?php echo form_error('name'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group">
								<label class="control-label">Staff Type <span class="required">*</span></label>
								<?php
									$type_list = $this->app_lib->getStaffTypes();
									echo form_dropdown("staff_type_id", $type_list, set_value('staff_type_id'), "class='form-control'
									data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
								?>
								<span class="error"><?php echo form_error('staff_type_id'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
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
					<div class="row">
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label">Salary Type <span class="required">*</span></label>
								<?php
									$type_list = $this->app_lib->getSalaryTypes();
									echo form_dropdown("salary_type_id", $type_list, set_value('salary_type_id'), "class='form-control'
									data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
								?>
								<span class="error"><?php echo form_error('salary_type_id'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label">Salary </label>
								<input type="text" class="form-control" name="salary" value="<?=set_value('salary')?>">
							</div>
							<span class="error"><?php echo form_error('salary'); ?></span>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Attachment File </label>
							<input type="file" name="attachment_file" class="dropify" data-height="110" data-default-file="" id="attachment_file" />
							<span class="error"></span>
						</div>
						</div>
					</div>
					<div class="row mb-md">
						<div class="col-md-12">
							<div class="form-group">
								<label for="input-file-now">Profile Picture</label>
								<input type="file" name="user_photo" class="dropify" data-allowed-file-extensions="png jpg jpeg"/>
								<span class="error"><?php echo form_error('user_photo'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-offset-10 col-md-2">
							<button type="submit" name="submit" value="save" class="btn btn btn-default btn-block"> <i class="fas fa-plus-circle"></i> Save</button>
						</div>
					</div>
				</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>