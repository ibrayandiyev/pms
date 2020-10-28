<section class="panel">
	<div class="tabs-custom">
		<!-- <ul class="nav nav-tabs">
			<?php
			//$staff_types = $this->db->get('staff_types')->result();
			//foreach ($staff_types as $row){
			?> 	
			<li class="<?php //if ($row->id == $staff_type_id) echo 'active'; ?>">
				<a href="<?php //echo base_url('employee/view/' . $row->id); ?>">
					<i class="far fa-user-circle"></i> <?php //echo $row->name?>
				</a>
			</li>
			<?php //} ?>
		</ul> -->
		<div class="tab-content">
			<div class="tab-pane box active">
				<div class="export_title">Employee List</div>
				<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th class="no-sort">Photo</th>
							<th>Employee ID</th>
							<th>Employee NO</th>
							<th>Name</th>
							<th>Staff Type</th>
							<th>Salary Type</th>
							<th>Salary</th>
							<th>Joining Date</th>
							<th>Attachment File</th>
							<?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
							<th>Action</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach ($stafflist as $row): ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td class="center">
								<img src="<?php echo get_image_url('staff', $row->photo); ?>" height="50" />
							</td>
							<td><?php echo $row->employee_id;?></td>
							<td><?php echo $row->employee_no; ?></td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo $row->staff_type; ?></td>
							<td><?php echo $row->salary_type; ?></td>
							<td><?php echo $row->salary; ?></td>
							<td><?php echo $row->joining_date; ?></td>
							<td class="min-w-c">
							<?php if (!empty($row->enc_name)) { ?>
								<a href="<?php echo base_url('employee/documents_download?file=' . $row->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="Download">
									<i class="fas fa-cloud-download-alt"></i>
								</a>
								<a href="<?php echo base_url('uploads/attachments/documents/' . $row->enc_name); ?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" target="_blank" data-original-title="Display">
									<i class="fas fa-file-alt"></i>
								</a>
							<?php } ?>
							</td>
							<?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
							<td class="min-w-c">
								<a href="<?php echo base_url('employee/profile/'.$row->id); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" 
								data-original-title="Edit">
									<i class="fas fa-pen-nib"></i>
								</a>
								<?php echo btn_delete('employee/delete/' . $row->id); ?>
							</td>
							<?php endif; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>