<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
            <li>
				<a href="<?=base_url('expense')?>"><i class="fas fa-list-ul"></i> Expense List</a>
			</li>
			<li class="active">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Expense Edit</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">
				<?php echo form_open_multipart('expense/expense_edit', array('class' => 'form-horizontal form-bordered frm-submit-data')); ?>
                    <input type="hidden" name="expense_old_id" value="<?=$expense['id']?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Project <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$arrayProjectList = $this->app_lib->getProjectList();
								echo form_dropdown("project_id", $arrayProjectList, $expense['project_id'], "class='form-control' id='project_id'
								data-plugin-selectTwo data-width='100%'");
							?>
							<span class="error"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Title</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="expense_title" value="<?=$expense['title']?>" placeholder="Expense Title" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account / Bank</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account" value="<?=$expense['type']?>" />
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
							echo form_dropdown("category", $arrayCategory, set_value('category', $expense['category']), "class='form-control' data-plugin-selectTwo data-width='100%'
							data-minimum-results-for-search='Infinity'");
						?>
						</div>
						<span class="error"><?=form_error('category')?></span>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label">Transaction Date <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="transaction_date" value="<?php echo set_value('transaction_date', $expense['date']); ?>" data-plugin-datepicker
							data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' readonly />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Amount <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="amount" autocomplete="off" value="<?php echo set_value('amount', $expense['amount']); ?>" placeholder="Amount" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Account No<span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="account_no" autocomplete="off" value="<?php echo set_value('account_no', $expense['account_no']); ?>" />
							<span class="error"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" id="description" name="description" placeholder="" rows="3" value=<?=$expense['description']?>></textarea>
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
