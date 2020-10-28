<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Receive Funds List</a>
			</li>
			<li>
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Add Receive Funds</a>
			</li>
		</ul>
		<div class="tab-content">
            <div id="list" class="tab-pane active">
				<div class="mb-md">
					<div class="export_title">Receive Funds List</div>
					<table class="table table-bordered table-hover table-condensed table_default">
						<thead>
							<tr>
								<th>#</th>
								<th>Project</th>
								<th>Account / Bank</th>
								<th>Amount</th>
								<th>Transaction No</th>
                                <th>Date</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1; foreach ($receivefundslist as $row): ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?=$row['project_name'] . $row['project_no']?></td>
								<td><?=$row['account_name']?></td>
								<td><?=$row['amount']?></td>
								<td><?=$row['transaction_no']?></td>
								<td><?php echo _d($row['date']); ?></td>
								<td><?=$row['description']?></td>
								<td class="min-w-xs">
									<a href="<?php echo base_url('receive_funds/edit/' . $row['id']); ?>" class="btn btn-circle btn-default icon"
									data-toggle="tooltip" data-original-title="Edit"> 
										<i class="fas fa-pen-nib"></i>
									</a>
									<a href="<?php echo base_url('uploads/attachments/receive_funds/' . $row['attachments']); ?>" class="btn btn-circle btn-default icon"
									data-toggle="tooltip" data-original-title="View Document"> 
										<i class="fas fa-eye"></i>
									</a>
									<?php echo btn_delete('receive_funds/delete/' . $row['id']); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="create">
				<?php echo form_open_multipart('receive_funds/save', array('class' => 'form-horizontal form-bordered frm-submit-data')); ?>
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
						<label class="col-md-3 control-label">Acount/Bank <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$arrayAccountList = $this->app_lib->getAccountList();
								echo form_dropdown("account_id", $arrayAccountList, "", "class='form-control' id='account_id'
								data-plugin-selectTwo data-width='100%'");
							?>
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
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="5" ></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Transaction No <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="transaction_no" value="" />
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
