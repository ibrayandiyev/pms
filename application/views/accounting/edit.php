
<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="<?php echo base_url('accounting'); ?>"><i class="fas fa-list-ul"></i> Account List</a>
			</li>
			<li class="active">
				<a href="#edit" data-toggle="tab"><i class="far fa-edit"></i> Edit Account</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="edit">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered frm-submit')); ?>
					<input type="hidden" name="account_id" value="<?php echo html_escape($account['id']); ?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Account Name <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_name" value="<?=$account['name']?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account Number </label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_number" value="<?=$account['number']?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="3"><?=$account['description']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Initial Balance</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="opening_balance" value="<?=$account['balance']?>" />
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
									<i class="fas fa-plus-circle"></i> Update
								</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>