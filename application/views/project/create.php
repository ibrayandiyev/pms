<section class="panel">
	<div class="tabs-custom">
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-crown"></i> Create New Project
			</h4>
		</div>
		<div class="tab-content">
			<div class="tab-pane active">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-bordered form-horizontal'));?>
					<div class="form-group">
						<label class="col-md-3 control-label">Project ID <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="" value="<?=$project_id?>" disabled="disabled" />
						</div>
						<input type="hidden" class="form-control" name="project_id" value="<?=$project_id?>"  />
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Donor <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$donor_list = $this->app_lib->getDonorList();
								echo form_dropdown("donor_id", $donor_list, set_value('donor_id'), "class='form-control' data-width='100%' id='donor_id'
								data-plugin-selectTwo  data-minimum-results-for-search='Infinity'");
							?>
							<span class="error"><?php echo form_error('donor_id'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Project Name <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="project_name" value="" />
							<span class="error"><?php echo form_error('project_name'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Project Date <span class="required">*</span></label>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
								<input type="text" class="form-control" name="project_date" id="project_date" 
								value="<?=set_value('project_date', date("Y/m/d") . ' - ' . date("Y/m/d", strtotime("+2 day")))?>" />
							</div>
							<span class="error"><?php echo form_error('project_date'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-6">
							<textarea name="description" class="summernote"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Location</label>
						<div class="col-md-6">
							<textarea name="location" class="form-control"></textarea>
							<span class="error"><?php echo form_error('location'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Budget <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="budget" value="" />
							<span class="error"><?php echo form_error('budget'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Project No <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="project_no" value="" />
							<span class="error"><?php echo form_error('project_no'); ?></span>
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-offset-3 col-md-2">
								<button type="submit" class="btn btn-default btn-block">
									<i class="fas fa-plus-circle"></i> Create
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function () {
		$('#project_date').daterangepicker({
			opens: 'left',
		    locale: {format: 'YYYY/MM/DD'}
		});
		
	});
</script>