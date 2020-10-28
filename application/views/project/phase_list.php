<section class="panel">
	<div class="tabs-custom">
		<div class="tab-content">
			<div class="tab-pane box active">
				<div class="export_title">Phase List</div>
				<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Project</th>
							<th>Phase No</th>
							<th>Phase Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$count = 1;
					if (count($phase)) {
						foreach ($phase as $row):
					?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $row['p_name'] . $row['p_no']; ?></td>
							<th><?php echo $row['phase_no']; ?></th>
							<td><?php echo $row['name']; ?></td>
							<td class="min-w-xs">
								<?php if (!is_donor_loggedin()): ?>
								<a class="btn btn-default btn-circle icon" href="javascript:void(0);" onclick="getPhaseDetails('<?=$row['id']?>')">
									<i class="fas fa-pen-nib"></i>
								</a>
								<?php endif; ?>
								<a href="<?php echo base_url('projects/phase_document/'.$row['id']); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="Documents">
									<i class="fas fa-paperclip"></i>
								</a>
								<?php if (!is_donor_loggedin()): ?>
								<?php echo btn_delete('projects/phase_delete/' . $row['id']); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php
						endforeach;
					}else{
							echo '<tr><td colspan="5"><h5 class="text-danger text-center">' . 'No information available' . '</td></tr>';
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<!-- Modal Edit Phase -->
<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="far fa-edit"></i> Edit Phase</h4>
		</header>
		<?php echo form_open('projects/phase_edit', array('class' => 'frm-submit')); ?>
			<div class="panel-body">
				<input type="hidden" name="phase_id" id="phase_id" value="" />
				<div class="form-group">
					<label class="control-label">Project ID <span class="required">*</span></label>
					<?php
						$arrayProject = $this->app_lib->getProjectList();
						echo form_dropdown("project_id", $arrayProject, set_value('project_id'), "class='form-control' id='eproject_id'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
					<span class="error"></span>
				</div>
				<div class="form-group mb-md">
					<label class="control-label"></label>Pahse No <span class="required">*</span></label>
					<input type="text" class="form-control" name="phase_no" value="<?php echo set_value('phase_no'); ?>" id="ephase_no"/>
					<span class="error"></span>
				</div>
				<div class="form-group mb-md">
					<label class="control-label"></label>Pahse Name <span class="required">*</span></label>
					<input type="text" class="form-control" name="phase_name" value="<?php echo set_value('phase_name'); ?>" id="ephase_name" />
					<span class="error"></span>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> Update
						</button>
						<button class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		<?php echo form_close(); ?>
	</section>
</div>