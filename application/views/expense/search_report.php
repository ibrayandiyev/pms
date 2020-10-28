<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title">Payroll Search Report</h4>
            </header>
            <?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
                <div class="panel-body">
                    <div class="row mb-sm">
                        <div class="col-md-6 mb-sm">
                            <div class="form-group">
                                <label class="control-label">Project </label>
                                <?php
                                    $arrayProjectID = $this->app_lib->getProjectList();
                                    echo form_dropdown("project_id", $arrayProjectID, set_value('project_id'), "class='form-control'
                                    data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-sm">
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

        <?php if(isset($transactions)): ?>
            <section class="panel" data-appear-animation-delay="100">
                <header class="panel-heading">
                    <h4 class="panel-title">Transaction List</h4>
                </header>
                <div class="panel-body">
                    <div class="mb-sm mt-xs">
                        <table class="table table-bordered table-hover table-condensed table_default">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Title</th>
                                    <th>Account / Bank</th>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Amount No</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; foreach ($transactions as $row): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?=$row->project_name . $row->project_no?></td>
                                    <td><?=$row->title?></td>
                                    <td><?=$row->type?></td>
                                    <td><?=$row->date?></td>
                                    <td><?=$row->amount?></td>
                                    <td><?=$row->account_no?></td>
                                    <td><?=$row->description?></td>
                                    <td class="min-w-xs">
                                        <a href="<?php echo base_url('expense/expense_edit/' . $row->id); ?>" class="btn btn-circle btn-default icon"
                                        data-toggle="tooltip" data-original-title="Edit"> 
                                            <i class="fas fa-pen-nib"></i>
                                        </a>
                                        <?php if (!empty($row->attachments)): ?>
                                        <a href="<?php echo base_url('uploads/attachments/transactions/' . $row->attachments); ?>" class="btn btn-circle btn-default icon"
                                        data-toggle="tooltip" data-original-title="View Document"> 
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php echo btn_delete('expense/expense_delete/' . $row->id); ?>
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