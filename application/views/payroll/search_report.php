<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title">Payroll Search Report</h4>
            </header>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
                <div class="panel-body">
                    <div class="row mb-sm">
                        <div class="col-md-4 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Project </label>
                                <?php
                                    $arrayProjectID = $this->app_lib->getProjectList();
                                    echo form_dropdown("project_id", $arrayProjectID, set_value('project_id'), "class='form-control'
                                    data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Employee </label>
                                <?php
                                    $arrayEmployID = $this->app_lib->getEmployeeIDList();
                                    echo form_dropdown("staff_id", $arrayEmployID, set_value('staff_id'), "class='form-control' data-plugin-selectTwo
                                    data-width='100%' data-minimum-results-for-search='Infinity' ");
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
                                    <input type="text" class="form-control daterange" name="daterange" value="<?php echo set_value('daterange', date("Y/m/d") . ' - ' . date("Y/m/d")); ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            <button type="submit" name="search" value="1" class="btn btn-default btn-block"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </section>

        <?php if(isset($payrolls)): ?>
            <section class="panel" data-appear-animation-delay="100">
                <header class="panel-heading">
                    <h4 class="panel-title">Staff List</h4>
                </header>
                <div class="panel-body">
                    <div class="mb-sm mt-xs">
                        <table class="table table-bordered table-hover table-condensed table_default" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Employee</th>
                                    <th>Salary</th>
                                    <th>Salary Type</th>
                                    <th>Paid Amount</th>
                                    <th>Created At</th>
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
                                    <td><?php echo _d($payroll->created_at); ?></td>
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
                                        <a href="<?php echo base_url('payroll/documents_download?file=' . $payroll->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Download">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </a>
                                        <a href="<?php echo base_url('uploads/attachments/payroll/' . $payroll->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" target="_blank" data-original-title="View">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <?php echo btn_delete('payroll/delete/'.$payroll->id);?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

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