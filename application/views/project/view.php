<section class="panel">
	<div class="tabs-custom">
		<div class="tab-content">
			<div class="tab-pane box active">
				<div class="export_title">Project List</div>
				<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Project</th>
							<th>Donor</th>
							<th>Project Name</th>
							<th>Project Date</th>
							<th>Description</th>
							<th>Location</th>
							<th>Budget</th>
							<th>Project No</th>
							<th>Action</th>
					</thead>
					<tbody>
						<?php $i = 1; foreach ($project_list as $row): ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $row->project_name . $row->project_no; ?></td>
							<td><?php echo $row->donor_name;?></td>
							<td><?php echo $row->project_name; ?></td>
							<td><?php echo $row->project_date; ?></td>
							<td class="text-center">
								<!-- view modal link -->
								<?php if (!empty($row->description)): ?>
								<a href="javascript:void(0);" class="btn btn-circle btn-default icon" style="width:80%" onclick="viewDescription('<?=$row->id?>');">
									<i class="far fa-eye"></i>
								</a>
								<?php endif; ?>
							</td>
							<td><?php echo $row->location; ?></td>
							<td><?php echo $row->budget; ?></td>
							<td><?php echo $row->project_no; ?></td>
							<td class="min-w-c">
								<?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
								<a href="<?php echo base_url('projects/update/'.$row->id); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" 
								data-original-title="Edit">
									<i class="fas fa-pen-nib"></i>
								</a>
								<?php endif; ?>
								<a href="<?php echo base_url('projects/details/'.$row->id); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" 
								data-original-title="Details">
									<i class="far fa-arrow-alt-circle-right"></i>
								</a>
								<?php if (is_superadmin_loggedin() || is_admin_loggedin()): ?>
								<?php echo btn_delete('projects/delete/' . $row->id); ?>
								<a href="<?php echo base_url('projects/phase/'.$row->id); ?>" class="btn btn-circle btn-default icon" style="width:70px" data-toggle="tooltip" 
								data-original-title="Add Phase">
									<i class="far fa-plus-square"></i>
								</a>
								<?php endif; ?>
								<a href="<?php echo base_url('projects/phase_list/'.$row->id); ?>" class="btn btn-circle btn-default icon" style="width:70px" data-toggle="tooltip" 
								data-original-title="Phase List">
									<i class="far fa-eye"></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-info-circle"></i> Description</h4>
		</header>
		<div class="panel-body">
			<div id="printResult" class="pt-sm pb-sm">
				<div class="table-responsive">						
					<table class="table table-bordered table-condensed tbr-top" id="ev_table"></table>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss">
						Close
					</button>
				</div>
			</div>
		</footer>
	</section>
</div>
