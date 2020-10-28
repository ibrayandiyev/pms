<div class="row">
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> Add Phase</h4>
			</header>
			<?php echo form_open($this->uri->uri_string()); ?>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">Project <span class="required">*</span></label>
						<?php
							$arrayProject = $this->app_lib->getProjectList();
							echo form_dropdown("project_id", $arrayProject, set_value('project_id', $p_id), "class='form-control' id='project_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
						?>
						<span class="error"><?=form_error('project_id')?></span>
					</div>
					<div class="form-group mb-md">
						<label class="control-label"></label>Pahse No <span class="required">*</span></label>
						<input type="text" class="form-control" name="phase_no" value="<?php echo set_value('phase_no'); ?>" />
						<span class="error"><?=form_error('phase_no')?></span>
					</div>
					<div class="form-group mb-md">
						<label class="control-label"></label>Pahse Name <span class="required">*</span></label>
						<input type="text" class="form-control" name="phase_name" value="<?php echo set_value('phase_name'); ?>" />
						<span class="error"><?=form_error('phase_name')?></span>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-default pull-right" type="submit"><i class="fas fa-plus-circle"></i> Add</button>
						</div>	
					</div>
				</div>
			<?php echo form_close(); ?>
		</section>
	</div>
	<div class="col-md-7">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-list-ul"></i> Phase List</h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed mb-none">
						<thead>
							<tr>
								<th>#</th>
								<th>Project ID</th>
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
									<a class="btn btn-default btn-circle icon" href="javascript:void(0);" onclick="getPhaseDetails('<?=$row['id']?>')">
										<i class="fas fa-pen-nib"></i>
									</a>
									<a href="<?php echo base_url('projects/phase_document/'.$row['id']); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="Documents">
										<i class="fas fa-paperclip"></i>
									</a>
									<?php echo btn_delete('projects/phase_delete/' . $row['id']); ?>
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
		</section>
	</div>
</div>
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