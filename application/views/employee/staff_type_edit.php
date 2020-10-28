<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?php echo base_url('staff_types'); ?>"><i class="fas fa-list-ul"></i> Staff Types List</a>
			</li>
			<li class="active">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Staff Type Create</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">
	            <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
	            <input type="hidden" name="id" value="<?php echo $staff_type['id']; ?>">
					<div class="form-group <?php if (form_error('staff_type')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Staff Type Name <span class="required">*</span></label>
						<div class="col-md-6 mb-sm">
							<input type="text" class="form-control" name="staff_type" value="<?php echo set_value('staff_type', $staff_type['name']); ?>">
							<span class="error"><?php echo form_error('staff_type'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('update_date')) echo 'has-error'; ?>">
                        <label class="col-md-3 control-label">Update Date <span class="required">*</span></label>
                        <div class="col-md-6 mb-sm">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
                                <input type="text" class="form-control" name="update_date" data-plugin-datepicker data-plugin-options='{ "todayHighlight" : true }'
                                autocomplete="off" value="<?=set_value('update_date')?>" />
                            </div>
                            <span class="error"><?php echo form_error('update_date'); ?></span>
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