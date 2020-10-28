<div class="dashboard-page">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="panel">
				<div class="row widget-row-in">
					<div class="col-lg-3 col-sm-12 ">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-user-tie"></i>
									<h5 class="text-muted">Administrators</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary">
									<?php
										$active = $this->dashboard_model->getUserCounter('administrator', 'active');
										echo $active;
									?>
									/
									<?php
										$admin = $this->dashboard_model->getUserCounter('administrator', 'total');
										echo $admin;
									?>
									</h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
								<?php if ($admin != 0){ ?>
									<div class="box-top-line line-color-danger" style="width: <?=($active/$admin)*100?>%">
									</div>
								<?php } else { ?>
									<div class="box-top-line line-color-danger" style="width: 100%">
									</div>
								<?php } ?>
									<div class="text-right">
										<span class="text-muted"><b>ACTIVE COUNT</b></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-12">
						<div class="panel-body">
							<div class="widget-col-in row">
								<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-user-tie"></i>
									<h5 class="text-muted">Supervisors</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary">
									<?php
										$active = $this->dashboard_model->getUserCounter('supervisor', 'active');
										echo $active;
									?>
									/
									<?php
										$visor = $this->dashboard_model->getUserCounter('supervisor', 'total');
										echo $visor;
									?>
									</h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
								<?php if ($visor != 0){ ?>
									<div class="box-top-line line-color-danger" style="width: <?=($active/$visor)*100?>%">
									</div>
								<?php } else { ?>
									<div class="box-top-line line-color-danger" style="width: 100%">
									</div>
								<?php } ?>
									<div class="text-right">
										<span class="text-muted"><b>ACTIVE COUNT</b></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-12 ">
						<div class="panel-body">
							<div class="widget-col-in row">
							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-chalkboard-teacher"></i>
									<h5 class="text-muted">Donors</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary">
									<?php
										$active = $this->dashboard_model->getUserCounter('donor', 'active');
										echo $active;
									?>
									/
									<?php
										$donor = $this->dashboard_model->getUserCounter('donor', 'total');
										echo $donor;
									?>
									</h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<?php if ($donor != 0){ ?>
										<div class="box-top-line line-color-danger" style="width: <?=($active/$donor)*100?>%">
										</div>
									<?php } else { ?>
										<div class="box-top-line line-color-danger" style="width: 100%">
										</div>
									<?php } ?>
									<div class="text-right">
										<span class="text-muted"><b>ACTIVE COUNT</b></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-12 ">
						<div class="panel-body">
							<div class="widget-col-in row">
							<div class="col-md-6 col-sm-6 col-xs-6"> <i class="fas fa-users"></i>
									<h5 class="text-muted">Employee</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h3 class="counter text-right mt-md text-primary">
									<?php
										$count = $this->db->get('staff')->num_rows();
										echo $count;
									?>
									</h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-danger">
										<span class="text-muted text-uppercase"><b>Total Employee</b></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-5 col-xl-4">
			<div class="row">
				<div class="col-lg-12">
					<section class="panel pg-fw">
						<div class="panel-body">
							<h4 class="chart-title mb-xs">Browser Stats</h4>
							<div class="">
								<canvas id="chart_2" height="250px"></canvas>
							</div>
							<div class="text-center">
								<ul class="list-inline">
									<li>
										<h6 class="text-muted"><i class="fa fa-circle" style="color:#0092EE"></i> Google Chrome</h6>
									</li>
									<li>
										<h6 class="text-muted"><i class="fa fa-circle" style="color:#22AF47"></i> Internet Explorer</h6>
									</li>
									<li>
										<h6 class="text-muted"><i class="fa fa-circle" style="color:#F83F37"></i> Mozila Firefox</h6>
									</li>
									<li>
										<h6 class="text-muted"><i class="fa fa-circle" style="color:#FFBF36"></i> Safari</h6>
									</li>
								</ul>
							</div>	
						</div>
					</section>
				</div>
				
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="calendar-wrap">
									<div id="calendar_small" class="small-calendar"></div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-7 col-xl-8">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default border-panel card-view">
						<div class="panel-heading">
							<div class="input-group mb-15">
								<div class="input-group-addon"><i class="fa fa-search"></i></div>
								<input type="text" id="address" class="form-control" value= "12890 Cleburne Hwy Cresson, TX" />
								<div class="input-group-btn">
									<button id="submit" class="btn btn-primary btn-rounded btn-icon left-icon"><i class="fa fa-check"></i></button>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div id="pms_map" style="height:523px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Row -->
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h5 style="color:#637da2;font-size:40px">
									<?php
										echo $this->db->get('projects')->num_rows();
									?>
									</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right">
									<i class="fas fa-warehouse" style="font-size:50px;"></i>
								</div>	
							</div>
							<hr style="background:#637da2"/>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<h4 style="color:#637da2">TOTAL PROJECTS</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h5 style="color:#637da2;font-size:40px">
									<?php
										echo $this->db->get('transactions')->num_rows();
									?>
									</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right">
									<i class="fas fa-money-check-alt" style="font-size:50px;"></i>
								</div>	
							</div>
							<hr style="background:#637da2"/>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<h4 style="color:#637da2">TRANSACTIONS</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h5 style="color:#637da2;font-size:40px">
									<?php
										$total_visits = 0;
										foreach ($user_urgent as $row) {
											$total_visits = $total_visits + $row->visits;
										}
										echo $total_visits;
									?>
									</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right">
									<i class="fa fa-male" style="font-size:50px;"></i>
									<i class="fa fa-female" style="font-size:50px;"></i>
								</div>	
							</div>
							<hr style="background:#637da2"/>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<h4 style="color:#637da2">TOTLAL VISITS</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Row -->
		</div>
	</div>
</div>
	
	<!-- Google map -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATD-1Cy4a5ltcel9jRVXGePRNxVB7A_Go&callback=initMap&libraries=&v=weekly"
	defer
	></script>

	<script language="javascript">
		"use strict";

		function initMap() {
			const map = new google.maps.Map(document.getElementById("pms_map"), {
				zoom: 5,
				center: {
				lat: 32.580708,
				lng: -97.678263
				}
			});
			const geocoder = new google.maps.Geocoder();
				document.getElementById("submit").addEventListener("click", () => {
					geocodeAddress(geocoder, map);
			});
		}

		function geocodeAddress(geocoder, resultsMap) {
			const address = document.getElementById("address").value;
			geocoder.geocode(
				{
				address: address
				},
				(results, status) => {
				if (status === "OK") {
					resultsMap.setCenter(results[0].geometry.location);
					new google.maps.Marker({
					map: resultsMap,
					position: results[0].geometry.location
					});
				} else {
					alert(
					"Geocode was not successful for the following reason: " + status
					);
				}
				}
			);
		}
		
		$(document).ready(function() {
			if( $('#chart_2').length > 0 ){
				var ctx6 = document.getElementById("chart_2").getContext("2d");
				var data6 = {
					labels: [
					"Chrome",
					"Internet Explorer",
					"Firefox",
					"Safari",
					"Others"
				],
				datasets: [
					{
						data: [<?=$user_urgent['0']->stats_value?>,<?=$user_urgent['1']->stats_value?>,<?=$user_urgent['2']->stats_value?>,<?=$user_urgent['3']->stats_value?>, <?=$user_urgent['4']->stats_value?>],
						backgroundColor: [
							"#0092ee",
							"#22af47",
							"#f83f37",
							"#ffbf36",
							"#A4DF40"
						],
						hoverBackgroundColor: [
							"#2879FF",
							"#01C853",
							"#FF2A00",
							"#F8EC2E",
							"#91CB3D"
						]
					}]
				};
				
				var pieChart  = new Chart(ctx6,{
					type: 'doughnut',
					data: data6,
					options: {
						animation: {
							duration:	3000
						},
						responsive: true,
						maintainAspectRatio:false,
						cutoutPercentage: 60,
						legend: {
							display:false
						},
						tooltip: {
							backgroundColor:'rgba(33,33,33,1)',
							cornerRadius:0,
							footerFontFamily:"'Roboto'"
						},
						elements: {
							arc: {
								borderWidth: 0
							}
						}
					}
				});
			}
		});
</script>

