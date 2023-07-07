<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url() ?>plugins/jquery/jquery.form.min.js"></script>
<?php
if (!$this->session->schoolmis_login_level) {
	redirect(base_url('login'));
}
$this->db->query('REFRESH MATERIALIZED VIEW profile.view_gete_pass;');
$uri = $this->session->schoolmis_login_uri;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mt-2">
			<div class="col-sm-6">
				<!-- <h1><i class="nav-icon fas fa-edit"></i> Data Entry</h1> -->
			</div>
			<!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Advanced Form</li>
        </ol>
      </div> -->
		</div>
	</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- <div class="row">
			<div class="col-1 col-xl-1 col-md-1 col-sm-0">
			</div>
			<div class="col-10 col-xl-10 col-md-10 col-sm-12 form_save_dataGuardInfo">
				<div class="row">
					<div class="col-md-12"> -->
		<form id="form_save_dataGateSearch">
			<!-- <div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h5><i class="icon fas fa-info"></i> Alert!</h5>
							Info alert preview. This alert is dismissable.
						</div> -->
			<div class="row">
				<div class="col-1 col-lg-2 col-xl-3"></div>
				<div class="col-10 col-lg-8 col-xl-6">
					<div class="callout callout-info get_selection">
						<h5>Gate Assignment:</h5>
						<div class="input-group input-group-lg mb-2" style="width: 100%;">
							<div class="input-group-prepend">
								<small class="input-group-text text-lg text-bold">GATE</small>
							</div>
							<select class="form-control form-control-lg selectGateList" placeholder="GATE" name="gate_select" id="gate_select">
							</select>

							<div class="input-group-append">
								<button type="button" class="btn btn-success btn-lg submitBtnGRADE_SLIP text-white text-lg text-bold" onclick="vdetails();"><i class="fa fa-paper-plane"></i> SUBMIT</button>
							</div>
						</div>
						<p><i>Please select the "<b>GATE</b> assignment" option to initiate the scanning process for ID.</i></p>

					</div>
				</div>
				<div class="col-1 col-lg-2 col-xl-3"></div>
			</div>

			<div class="row">
				<div class="col-1 col-xs-0 col-sm-0"></div>
				<div class="col-10 col-xs-12 col-sm-12">
					<div class="card card-navy view_details" style="display:none;">
						<!-- <div class="card card-navy view_details"> -->
						<div class="card-header">
							<h1 class="card-title header text-lg text-bold"><i class="fa fa-card"></i> SELECT GATE</h1>
							<input type="text" id="qr" hidden />
							<!-- <div class="card-tools">
												<button type="button" class="btn btn-tool collapseAssignedSectionList" data-card-widget="collapse"><i class="fas fa-plus"></i>
												</button>
											</div> -->
							<div class="float-right">
								<button type="button" class="btn btn-default btn-xs gateSelect" onclick="vdetails();"><i class="fas fa-door-open"></i> Gate Selection</button>
								<!-- <button type="button" class="btn btn-xs btn-info openreader-multi3" id="openreader-multi3" data-qrr-multiple="false" data-qrr-target="#multiple" data-qrr-skip-duplicates="false" onclick="$('.openreader-multi3').hide();$('.qrr-close').show();" style="display:none;">
														<i class="fa fa-qrcode"></i> Read QR Code
													</button>
													<button type="button" class="btn btn-xs btn-default qrr-close" onclick="$('#qrr-close').trigger('click');$('.openreader-multi3').show();$('.qrr-close').hide();">
														<i class="fa fa-times"></i> Close QR Code Reader
													</button> -->
							</div>
							<div class="card-tools">
								<!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button> -->
							</div>
						</div> <!-- /.card -->
						<!-- /.card-header -->
						<div class="card-body">
							<!-- <div hidden>
												<h5>Guide for correct scanning:</h5>
												<div class="row px-5">
													<div class="col-6">
														<div class="card card-success shadow">
															<div class="card-header">
																<h3 class="card-title text-bold text-lg">FRONT - IN</h3>
																<div class="card-tools">
																</div>

															</div>

															<div class="card-body p-1 text-center">
																<img src="<?= base_url('dist/img/media/sample/front.jpg'); ?>" width="75%" height="250" class="" alt="User Image">
															</div>

														</div>
													</div>
													<div class="col-6">
														<div class="card card-danger shadow">
															<div class="card-header">
																<h3 class="card-title text-bold text-lg">BACK - OUT</h3>
																<div class="card-tools">
																</div>

															</div>

															<div class="card-body p-1 text-center">
																<img src="<?= base_url('dist/img/media/sample/back.jpg'); ?>" width="75%" height="250" class="" alt="User Image">
															</div>

														</div>
													</div>
												</div>
											</div> -->
							<div class="card-body text-center">
								<dl>
									<!-- <div class="position-relative text-center">
												<img name="previewPic" src="<?= base_url("dist/img/media/icons/1x1.png") ?>" style="border:3px solid #63a4ca;cursor:pointer" alt="Photo 1" width="250" class="img-fluid">
											</div> -->
									<div class="image">
										<img name="previewPic" src="<?= base_url("dist/img/media/icons/1x1.png") ?>" style="border:3px solid #63a4ca;cursor:pointer;border-radius:20px;" class="elevation-2" width="280" height="280" alt="User Image">
									</div>
									<dt style="font-size: 5.1rem;" id="name">-</dt>
									<dd style="font-size: 4rem;" id="type">-</dd>
								</dl>
							</div>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
				<div class="col-1 col-xs-0 col-sm-0"></div>
			</div>
			<!-- /.card -->
		</form>
		<!-- </div> -->
		<!-- /.col -->
		<!-- </div> -->
		<!-- /.row -->
		<!-- END ACCORDION & CAROUSEL-->
		<!-- </div> -->
		<!-- <div class="col-1 col-xl-1 col-md-1 col-sm-0">
				sdf
			</div> -->
		<!-- </div> -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
	$(function() {
		let f1 = "GateSearch";
		let intervalId = "";
		getFetchList(f1, "GateList", "PartyList", 0, {
			v: 20
		}, 0);

		$("document").ready(function() {
			var barcode = "";
			// var beep = new Audio("<?= base_url() ?>plugins/qrcode/audio/beep.mp3");
			// beep.play();

			// Listen for keydown event on a specific element or the document
			$(document).on('keydown', function(event) {
				var key = event.key;

				// Check if key is a valid barcode character
				if (key.length === 1 && /^[0-9a-zA-Z]$/.test(key)) {
					barcode += key;
				}
			});

			// Listen for keyup event on a specific element or the document
			$(document).on('keyup', function(event) {
				var key = event.key;

				// Check if key is Enter (carriage return)
				if (key === "Enter") {
					// Barcode scanning is complete
					// Retrieve the scanned value
					var scannedValue = barcode;

					// Do something with the scanned value
					console.log("Scanned Value:", scannedValue);
					getQRPerson({
						v: scannedValue,
						g_id: $("#gate_select").val(),
						g_nm: $("#gate_select option:selected").text()
					}, f1);

					// Reset the barcode variable for the next scan
					barcode = "";
				}
			});
		});

		// setInterval(() => {
		// 	!$("#qr").val() ?
		// 		"" :
		// 		getQRPerson({
		// 			v: $("#qr").val()
		// 		}, f1);
		// }, 1000)
	});
</script>