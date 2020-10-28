<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<div class="tabs-custom">
				<ul class="nav nav-tabs">
					<li>
						<a href="<?=base_url('country_list')?>"><i class="fas fa-list-ul"></i> Country List</a>
					</li>
					<li class="active">
						<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Edit Country Name</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="create">
						<?php echo form_open('country_list/save', array('class' => 'form-bordered form-horizontal frm-submit')); ?>
						<input type="hidden" name="county_id" value="<?=$country_name_list['id']?>">
							<div class="form-group">
								<label class="col-md-3 control-label">Country Name <span class="required">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="country_name" value="<?=$country_name_list['name']?>" />
									<span class="error"></span>
								</div>
							</div>
							<footer class="panel-footer mt-lg">
								<div class="row">
									<div class="col-md-2 col-md-offset-3">
										<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
											<i class="fas fa-plus-circle"></i> Update
										</button>
									</div>
								</div>	
							</footer>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#field_type').on('change', function() {
			var field_type = $(this).val();
			if (field_type == "dropdown") {
				$('#checkbox_type').hide("slow");
				$('#common_type').hide("slow");
				$('#dropdown_type').show("slow");
			} else if (field_type == "checkbox") {
				$('#dropdown_type').hide("slow");
				$('#common_type').hide("slow");
				$('#checkbox_type').show("slow");
			} else {
				$('#checkbox_type').hide("slow");
				$('#dropdown_type').hide("slow");
				$('#common_type').show("slow");
			}
		});
	});
</script>