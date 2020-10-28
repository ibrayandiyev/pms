<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<div class="tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> Country Name List</a>
					</li>

					<li >
						<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Add Country Name</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="list" class="tab-pane active">
						<div class="mb-md">
							<table class="table table-bordered table-hover table-condensed mb-none table_default">
								<thead>
									<tr>
										<th>No</th>
										<th>Country Name</th>
										<th>Created</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$count = 1;
									foreach($country_name_list as $row):
								?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $row['name'];?></td>
										<td><?php echo $row['created_at'];?></td>
										<td class="min-w-c">
											<!--update link-->
											<a href="<?=base_url('country_list/edit/' . $row['id'])?>" class="btn btn-default btn-circle icon">
												<i class="fas fa-pen-nib"></i>
											</a>
											<!-- delete link -->
											<?php echo btn_delete('country_list/delete/' . $row['id']);?>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="create">
						<?php echo form_open('country_list/save', array('class' => 'form-bordered form-horizontal frm-submit')); ?>
							<div class="form-group">
								<label class="col-md-3 control-label">Country Name <span class="required">*</span></label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="country_name" value="<?=set_value('name')?>" />
									<span class="error"></span>
								</div>
							</div>
							<footer class="panel-footer mt-lg">
								<div class="row">
									<div class="col-md-2 col-md-offset-3">
										<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
											<i class="fas fa-plus-circle"></i> Save
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
