<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Expense List</a>
			</li>
			<li>
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Add Expense</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane active">
				<div class="mb-md">
					<div class="export_title">Expense List</div>
					<table class="table table-bordered table-hover table-condensed table_default">
						<thead>
							<tr>
								<th>#</th>
								<th>Project</th>
								<th>Title</th>
								<th>Account / Bank</th>
								<th>Transaction Date</th>
								<th>Amount</th>
								<th>Acount No</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1; foreach ($expenselist as $row): ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?=$row['project_name'] . $row['project_no']?></td>
								<td><?=$row['title']?></td>
								<td><?=$row['type']?></td>
								<td><?php echo _d($row['date']); ?></td>
								<td><?=$row['amount']?></td>
								<td><?=$row['account_no']?></td>
								<td><?=$row['description']?></td>
								<td class="min-w-xs">
									<a href="<?php echo base_url('expense/expense_edit/' . $row['id']); ?>" class="btn btn-circle btn-default icon"
									data-toggle="tooltip" data-original-title="Edit"> 
										<i class="fas fa-pen-nib"></i>
									</a>
									<?php if (!empty($row['attachments'])): ?>
									<a href="<?php echo base_url('uploads/attachments/transactions/' . $row['attachments']); ?>" class="btn btn-circle btn-default icon"
									data-toggle="tooltip" data-original-title="View Document"> 
										<i class="fas fa-eye"></i>
									</a>
									<?php endif; ?>
									<?php echo btn_delete('expense/expense_delete/' . $row['id']); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="create">
				<?php echo form_open_multipart('expense/expense_save', array('class' => 'form-horizontal form-bordered frm-submit-data')); ?>
					<div class="form-group">
						<label class="col-md-3 control-label">Project <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$arrayProjectList = $this->app_lib->getProjectList();
								echo form_dropdown("project_id", $arrayProjectList, "", "class='form-control' id='project_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Title</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="expense_title" value="" placeholder="Expense Title" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account / Bank</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account" value="" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Category <span class="required">*</span></label>
						<div class="col-md-6">
						<?php
							$arrayCategory = array(
								'' => 'select',
								'expense' => 'Expense',
								'other' => 'Other'
							);
							echo form_dropdown("category", $arrayCategory, set_value('category'), "class='form-control' data-plugin-selectTwo data-width='100%'
							data-minimum-results-for-search='Infinity'");
						?>
						</div>
						<span class="error"><?=form_error('category')?></span>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label">Transaction Date <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="transaction_date" value="<?php echo set_value('date', date('Y-m-d')); ?>" data-plugin-datepicker autocomplete="off"
							data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="amount" autocomplete="off" value="<?php echo set_value('amount'); ?>" placeholder="Amount" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account No<span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_no" autocomplete="off" value="<?php echo set_value('account_no'); ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="3" ></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Attachment</label>
						<div class="col-md-6 mb-md">
							<input type="file" name="attachment_file" class="dropify" data-height="70" />
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
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
