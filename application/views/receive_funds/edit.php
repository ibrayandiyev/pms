<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
            <li>
				<a href="<?=base_url('receive_funds')?>"><i class="fas fa-list-ul"></i> Receive Funds List</a>
			</li>
			<li class="active">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Receive Fund Edit</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">
                <?php echo form_open_multipart('receive_funds/save', array('class' => 'form-horizontal form-bordered frm-submit-data')); ?>
                    <input type="hidden" name="receive_fund_old_id" value="<?=$receivefund['id']?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Project <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$arrayProjectList = $this->app_lib->getProjectList();
								echo form_dropdown("project_id", $arrayProjectList, $receivefund['project_id'], "class='form-control' id='project_id'
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
								echo form_dropdown("account_id", $arrayAccountList, $receivefund['account_id'], "class='form-control' id='account_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="amount" autocomplete="off" value="<?php echo set_value('amount', $receivefund['amount']); ?>" placeholder="Amount" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="5" ><?=$receivefund['description']?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Transaction No <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="transaction_no" value="<?=$receivefund['transaction_no']?>" />
						</div>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label">Date </span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="date" value="<?php echo set_value('date', $receivefund['date']); ?>" data-plugin-datepicker autocomplete="off"
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
