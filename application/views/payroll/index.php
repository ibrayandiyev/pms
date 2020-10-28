<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
                <a href="#list" data-toggle="tab">
                    <i class="fas fa-list-ul"></i> Payroll List
                </a>
			</li>
			<li>
                <a href="#add" data-toggle="tab">
                   <i class="far fa-edit"></i> Create Payroll
                </a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane box active mb-md" id="list">
				<table class="table table-bordered table-hover mb-none tbr-top table_default">
					<thead>
						<tr>
							<th>#</th>
							<th>Project</th>
							<th>Employee</th>
							<th>Salary</th>
							<th>Salary Type</th>
							<th>Paid Amount</th>
							<th>Created At</th>
							<th>Updated At</th>
							<td>Description</td>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($payrolls as $payroll):
						?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $payroll->project_name . $payroll->project_no; ?></td>
							<td><?php echo $payroll->employee_name . $payroll->employee_no;?></td>
							<td><?php echo $payroll->salary_amount;?></td>
							<td><?php echo $payroll->salary_type; ?></td>
							<td><?php echo $payroll->paid_amount; ?></td>
							<td><?php echo _d($payroll->date); ?></td>
							<td><?php echo _d($payroll->updated_at); ?></td>
							<td class="text-center">
								<!-- view modal link -->
								<a href="javascript:void(0);" class="btn btn-circle btn-default icon" style="width:80%" onclick="viewDetail('<?=$payroll->id?>');">
									<i class="far fa-eye"></i>
								</a>
							</td>
							<td>
								<!-- deletion link -->
								<a href="<?php echo base_url('payroll/payroll_update/' . $payroll->id); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Edit">
                                    <i class="fas fa-pen-nib"></i>
								</a>
								<?php if (!empty($payroll->enc_name)): ?>
								<a href="<?php echo base_url('payroll/documents_download?file=' . $payroll->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Download">
                                    <i class="fas fa-cloud-download-alt"></i>
								</a>
								<a href="<?php echo base_url('uploads/attachments/payroll/' . $payroll->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" target="_blank" data-original-title="View">
									<i class="fas fa-file-alt"></i>
								</a>
								<?php endif; ?>
								<?php echo btn_delete('payroll/delete/'.$payroll->id);?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="tab-pane" id="add">
					<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-bordered form-horizontal frm-submit-data'));?>
						<div class="form-group">
							<label class="control-label col-md-3">Project ID <span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									$arrayProjectID= $this->app_lib->getProjectList();
									echo form_dropdown("project_id", $arrayProjectID, set_value('project_id'), "class='form-control' data-width='100%' id='project_id'
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
									echo form_dropdown("staff_id", $arrayEmployeeList, set_value('staff_id'), "class='form-control' data-width='100%' id='staff_id'
									data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
								?>
								<span class="error"></span>
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-3 control-label">Salary <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="salary_amount" value="" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Salary Type <span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									$arraySalaryType = $this->app_lib->getSalaryTypes();
									echo form_dropdown("salary_type_id", $arraySalaryType, set_value('salary_type_id'), "class='form-control' data-width='100%' id='salary_type_id'
									data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
								?>
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Paid Amount <span class="required">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="paid_amount" value="" />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label  class="col-md-3 control-label">Date </span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="date" value="<?php echo set_value('date', date('Y-m-d')); ?>" data-plugin-datepicker autocomplete="off"
								data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
								<span class="error"></span>
							</div>
						</div>
						<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea name="description" class="summernote"></textarea>
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

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-info-circle"></i> Payroll description</h4>
		</header>
		<div class="panel-body">
			<div id="printResult" class="pt-sm pb-sm">
				<div class="table-responsive">						
					<table class="table table-bordered table-condensed tbr-top" id="ev_table"></table>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss">
						Close
					</button>
				</div>
			</div>
		</footer>
	</section>
</div>
