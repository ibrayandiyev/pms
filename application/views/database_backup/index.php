<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#database_backup" data-toggle="tab">
				   <i class="fas fa-database"></i> Database List
				</a>
			</li>
			<li>
				<a href="#restore_database" data-toggle="tab">
				   <i class="fas fa-upload"></i> Restore Database
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane box active" id="database_backup">
			<div class="row">
			<div class="col-md-12">
				<div class="pull-right mb-md">
					<a href="<?php echo base_url('backup/create'); ?>" class="btn btn-default btn-sm">
						<i class="fas fa-paste"></i> Create Backup
					</a>
				</div>
			</div>
			</div>
				<table class="table table-bordered table-hover table_default">
					<thead>
						<tr>
							<th width="60">#</th>
							<th>Backup</th>
							<th>Backup Size</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$count = 1;
						$files = get_filenames(FCPATH.'/uploads/db_backup/');
						if (!empty($files)){
							foreach ($files as $file):
								$ext = pathinfo($file, PATHINFO_EXTENSION);
								if ($ext != "zip") continue;
								$_fullpath = FCPATH.'/uploads/db_backup/'.$file;
						?>
						<tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $file?></td>
							<td><?php echo bytesToSize($_fullpath);?></td>
							<td><?php
							    $getFormat = get_global_setting('date_format');
							    echo  date($getFormat, filectime($_fullpath)) . ", " . date('g:i A', filectime($_fullpath));
							?></td>
							<td>
								<!-- download link -->
								<a href="<?=base_url('backup/download?file='.$file) ?>" class="btn btn-circle btn-default">
								<i class="fas fa-download"></i> Download
								</a>
								<!-- deletion link -->
								<?php echo btn_delete('backup/delete_file/' . $file);?>
							</td>
						</tr>
						<?php endforeach; }; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane box" id="restore_database">
			<?php echo form_open_multipart('backup/restore_file', array('class' => 'form-horizontal frm-submit-data'));?>
				<div class="form-group mb-lg">
					<label class="col-md-3 control-label">File Upload <span class="required" aria-required="true">*</span></label>
					<div class="col-md-7">
						<input type="file" name="uploaded_file" class="dropify" data-height="140" data-allowed-file-extensions="zip" />
						<span class="error"></span>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-sm-offset-3">
						 <button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
						 	<i class="fas fa-cloud-upload-alt"></i> Upload SQL
						 </button>
						</div>
					</div>	
				</footer>
			<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>