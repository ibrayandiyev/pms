<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open('donors/disable_authentication', array('class' => 'validate')); ?>
			<header class="panel-heading">
				<h4 class="panel-title">
					<i class="fas fa-users"></i> Inactivated Donors List
				</h4>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-condensed table-hover table_default">
					<thead>
						<tr>
							<th width="40px">
								<div class="checkbox-replace">
									<label class="i-checks"><input type="checkbox" id="selectAllchkbox"><i style="border:#fff solid 1px"></i></label>
								</div>
							</th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Joining Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donorslist as $donor): ?>	
						<tr>
							<td class="checked-area">
								<div class="checkbox-replace">
									<label class="i-checks"><input type="checkbox" class="user_checkbox" name="views_bulk_operations[]" value="<?=html_escape($donor->id)?>"><i></i></label>
								</div>
							</td>
							<td><?php echo html_escape($donor->name);?></td>
							<td><?php echo html_escape($donor->username);?></td>
							<td><?php echo html_escape($donor->email);?></td>
							<td><?php echo html_escape($donor->phone);?></td>
							<td><?php echo html_escape($donor->joining_date);?></td>
							<td>
								<!-- update link -->
								<a href="<?php echo base_url('donors/edit/'.$donor->id);?>" class="btn btn-circle btn-default"><i class="fas fa-user-alt"></i> Edit</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="auth" value="1" class="btn btn-default btn-block"> <i class="fas fa-unlock-alt"></i> Authentication Activate</button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>