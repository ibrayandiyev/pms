
<div class="row">	
<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-users"></i> Supervisors List
			</h4>
		</header>
		<div class="panel-body">
			<div class="mb-md mt-md">
				<table class="table table-bordered table-hover table-condensed mb-none table_default">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Joining Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						$supervisorlist = $this->supervisor_model->getSupervisorList();
						if (count($supervisorlist)) {
							foreach($supervisorlist as $row):
						?>	
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $row->name;?></td>
							<td><?php echo $row->username;?></td>
							<td><?php echo $row->email;?></td>
							<td><?php echo $row->joining_date;?></td>
							<td class="min-w-xs">
							<!-- update link -->
							<a href="<?php echo base_url('supervisors/edit/' . $row->id);?>" class="btn btn-default btn-circle icon" data-toggle="tooltip"
							data-original-title="Edit">
								<i class="far fa-arrow-alt-circle-right"></i>
							</a>
							<!-- delete link -->
							<?php echo btn_delete('supervisors/delete/' . $row->id);?>
							</td>
						</tr>
						<?php endforeach; };?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>
