<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="<?php echo (!isset($validation_error) ? 'active' : ''); ?>">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Staff Type List</a>
			</li>
			<li class="<?php echo (isset($validation_error) ? 'active' : ''); ?>">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Create Staff Type</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane <?php echo (!isset($validation_error) ? 'active' : ''); ?>">
				<div class="mb-md">
					<table class="table table-bordered table-hover table-condensed table_default">
						<thead>
							<tr>
								<th>No</th>
								<th>Staff Type Name</th>
								<th>Add Date</th>
                                <th>Update Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($staff_types)){ $count = 1; foreach($staff_types as $row): ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['add_date']; ?></td>
                                <td><?php echo $row['update_date']; ?></td>
								<td class="min-w-xs">
									<a class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Edit" href="<?php echo base_url('staff_types/edit/' . $row['id']); ?>"><i class="fas fa-pen-nib"></i></a>
									<?php echo btn_delete('staff_types/delete/' . $row['id']); ?>
								</td>
							</tr>
							<?php endforeach; }?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane <?php echo (isset($validation_error) ? 'active' : ''); ?>" id="create">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
					<div class="form-group <?php if (form_error('staff_type')) echo 'has-error'; ?>">
						<label class="col-md-3 control-label">Staff Type Name <span class="required">*</span></label>
						<div class="col-md-6 mb-sm">
							<input type="text" class="form-control" name="staff_type" value="<?php echo set_value('staff_type'); ?>">
							<span class="error"><?php echo form_error('staff_type'); ?></span>
						</div>
					</div>
					<div class="form-group <?php if (form_error('add_date')) echo 'has-error'; ?>">
                        <label class="col-md-3 control-label">Add Date <span class="required">*</span></label>
                        <div class="col-md-6 mb-sm">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
                                <input type="text" class="form-control" name="add_date" data-plugin-datepicker data-plugin-options='{ "todayHighlight" : true }'
                                autocomplete="off" value="<?=set_value('add_date')?>" />
                            </div>
                            <span class="error"><?php echo form_error('add_date'); ?></span>
                        </div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" name="save" value="1" class="btn btn-default btn-block"><i class="fas fa-plus-circle"></i> Save</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>