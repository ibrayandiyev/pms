<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?php echo base_url('salary_types'); ?>"><i class="fas fa-list-ul"></i> Salary Types List</a>
			</li>
			<li class="active">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Salary Type Create</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">
	            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
	            <input type="hidden" name="id" value="<?php echo $salary_type['id']; ?>">
					<div class="form-group <?php if (form_error('staff_type')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Salary Type <span class="required">*</span></label>
						<div class="col-md-6 mb-sm">
							<input type="text" class="form-control" name="salary_type" value="<?php echo set_value('staff_type', $salary_type['name']); ?>">
							<span class="error"><?php echo form_error('salary_type'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('salary_unit')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Salary Unit</label>
						<div class="col-md-6 mb-sm">
							<input type="text" class="form-control" name="salary_unit" value="<?php echo set_value('salary_unit', $salary_type['unit']); ?>">
							<span class="error"><?php echo form_error('salary_unit'); ?></span>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" name="save" value="1" class="btn btn-default btn-block"><i class="fas fa-edit"></i> Update</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>