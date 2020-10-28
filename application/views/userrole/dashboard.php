
<div class="row">
	<div class="col-md-12 mb-lg">
		<div class="profile-head">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="image-content-center user-pro">
					<div class="preview">
						<?php if (is_donor_loggedin()) { ?>
						<img src="<?php echo get_image_url('donor', $donor['photo']);?>">
						<?php } else { ?>
						<img src="<?php echo get_image_url('supervisor', $supervisor['photo']);?>">
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-5 col-xl-5">
				<h5><?php echo is_donor_loggedin()?$donor['name']:$supervisor['name']; ?></h5>
				<p><?php echo is_donor_loggedin()?'Donor':'Supervisor'; ?></p>
			</div>
			<div class="col-md-12 col-lg-3 col-xl-4">
				<a href="<?=base_url('dashboard');?>" class="chil-shaw btn btn-primary btn-circle pull-right"><i class="fas fa-tachometer-alt"></i> dashboard</a>
			</div>
		</div>
	</div>
</div>

<div class="dashboard-page">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="panel">
			<div class="panel-body">
				<div class="row widget-row-in">
					<?php if (is_donor_loggedin()): ?>
					<div class="col-lg-6 col-sm-6 widget-row-d-br">
						<div class="widget-col-in row">
							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-crown"></i>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<h3 class="counter text-right mt-md text-primary">
									<?php 
										$this->db->where('donor_id', get_loggedin_user_id());
										echo $this->db->get('projects')->num_rows();
									?>
								</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="box-top-line line-color-primary" style="border-top:15px solid #01C853">
									<span class="text-muted">YOUR PROJECT</span>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if (is_supervisor_loggedin()): ?>
					<div class="col-lg-6 col-sm-6 widget-row-d-br">
						<div class="widget-col-in row">
							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="far fa-money-bill-alt"></i>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<h3 class="counter text-right mt-md text-primary">
									<?php 
										$this->db->where('supervisor_id', get_loggedin_user_id());
										echo $this->db->get('transactions')->num_rows();
									?>
								</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="box-top-line line-color-primary" style="border-top:15px solid #01C853">
									<span class="text-muted">YOUR TRANSACTIONS</span>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="col-lg-6 col-sm-6 widget-row-d-br">
						<div class="widget-col-in row">
							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fa fa-calendar"></i>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<h3 class="counter text-right mt-md text-primary">
								<?php 
									$this->db->select('created_at');
									$this->db->where('id', get_loggedin_user_id());
									$res = $this->db->get(is_donor_loggedin()?'donor':'supervisor')->result_array();
									echo _d($res[0]['created_at']);
								?>
								</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="box-top-line line-color-primary" style="border-top:15px solid #2879FF">
									<span class="text-muted">YOUR JOINGIN DATE</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
