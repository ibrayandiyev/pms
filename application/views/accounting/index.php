<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Account List</a>
			</li>
			<li>
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Create Account</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane active">
				<div class="mb-md">
					<div class="export_title">Account List</div>
					<table class="table table-bordered table-hover table-condensed table_default">
						<thead>
							<tr>
								<th width="50">#</th>
								<th>Account Name</th>
								<th>Account Number</th>
								<th>Description</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count = 1; foreach ($accountslist as $row):
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['number']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['date']; ?></td>
								<td>
									<a href="<?php echo base_url('accounting/edit/' . $row['id']); ?>" class="btn btn-circle btn-default icon"> 
										<i class="fas fa-pen-nib"></i>
									</a>
									<?php echo btn_delete('accounting/delete/' . $row['id']); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="create">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered frm-submit')); ?>
					<div class="form-group">
						<label class="col-md-3 control-label">Account Name <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_name" value="<?php echo set_value('account_name'); ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account Number </label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_number" value="<?php echo set_value('account_number'); ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="3"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Initial Balance</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="opening_balance" value="<?php echo set_value('opening_balance', 0); ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label">Date <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="date" value="<?php echo set_value('date', date('Y-m-d')); ?>" data-plugin-datepicker autocomplete="off"
							data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
							<span class="error"></span>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
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