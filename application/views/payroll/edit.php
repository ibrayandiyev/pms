<section class="panel">
	<div class="panel-heading">
		<h4 class="panel-title">
			<i class="far fa-address-card"></i> Edit Payroll
		</h4>
	</div>
	<div class="tabs-custom">
		<div class="tab-content">
			<div class="tab-pane box active">
					<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-bordered form-horizontal frm-submit-data'));?>
						<input type="hidden" name="payroll_id" value="<?=$payroll->id?>" />
						<div class="form-group">
							<label class="control-label col-md-3">Project <span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									$arrayProjectID= $this->app_lib->getProjectList();
									echo form_dropdown("project_id", $arrayProjectID, set_value('project_id', $payroll->project_id), "class='form-control' data-width='100%' id='project_id'
									data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
								?>
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Employee <span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									$arrayEmployeeList = $this->app_lib->getEmployeeIDList();
									echo form_dropdown("staff_id", $arrayEmployeeList, set_value('staff_id', $payroll->staff_id), "class='form-control' data-width='100%' id='staff_id'
									data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
								?>
								<span class="error"></span>
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-3 control-label">Salary <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="salary_amount" value="<?php echo $payroll->salary_amount; ?>" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Salary Type <span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									$arraySalaryType = $this->app_lib->getSalaryTypes();
									echo form_dropdown("salary_type_id", $arraySalaryType, set_value('salary_type_id', $payroll->salary_type_id), "class='form-control' data-width='100%' id='salary_type_id'
									data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
								?>
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Paid Amount <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="paid_amount" value="<?php echo $payroll->paid_amount; ?>" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label  class="col-md-3 control-label">Date </span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="date" value="<?php echo set_value('date', $payroll->date); ?>" data-plugin-datepicker autocomplete="off"
								data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea name="description" class="summernote" value="<?php echo $payroll->description; ?>"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Attachment</label>
						<div class="col-md-6">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input">
										<i class="fas fa-file fileupload-exists"></i>
										<span class="fileupload-preview"></span>
									</div>
									<span class="btn btn-default btn-file">
										<span class="fileupload-exists">Change</span>
										<span class="fileupload-new">Select file</span>
										<input type="file" name="document_file" />
										<input type="hidden" name="exist_file_name" id="exist_file_name" value="<?php echo $payroll->enc_name; ?>">
									</span>
									<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
							<span class="error"></span>
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-offset-3 col-md-2">
								<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
									<i class="fas fa-plus-circle"></i> Save
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
