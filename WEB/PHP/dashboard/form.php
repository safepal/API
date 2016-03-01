<?php
require('db.php');
include("auth.php");
if(isset($_POST['new']) &&$_POST['services[]'])
{
$ei_phoneNumber = $_REQUEST['ei_phoneNumber'];
$ei_gender  =$_REQUEST['ei_gender'];
$ei_age =$_REQUEST['ei_age'];
$ti_location =$_REQUEST['ti_location'];
$ti_date =$_REQUEST['ti_date'];
$ti_time  =$_REQUEST['ti_time'];
$ti_description =$_REQUEST['ti_description'];
$ti_type =$_REQUEST['ti_type'];
$ti_action =$_REQUEST['ti_action'];
$t1=implode(',',$_POST['services[]']);
$ins_query="insert into new_record(`ei_phoneNumber`,`ei_gender`,`ei_age`,`ti_location`,`ti_date`, `ti_time`, `ti_description`,`ti_type`,`ti_action`)values('$ei_phoneNumber','$ei_gender','$ei_age','$ti_location','$ti_date', '$ti_time', '$ti_description', '$ti_type', '$t1')";
mysql_query($ins_query) or die(mysql_error());
//$status = "New Record Inserted Successfully.</br></br><a href='post.php'>View Inserted Record</a>";
//echo '<META http-equiv="refresh" content="0,url=form.php">';
}

?>	
<!DOCTYPE html>

<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	

<head>
		<title>Safe Pal</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="assets/plugins/animate.css/animate.min.css">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR SUBVIEW CONTENTS -->
		<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">
		<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.theme.css">
		<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.transitions.css">
		<link rel="stylesheet" href="assets/plugins/summernote/dist/summernote.css">
		<link rel="stylesheet" href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-select/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
		<link rel="stylesheet" href="assets/plugins/DataTables/media/css/DT_bootstrap.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="assets/plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
		
		<!-- end: CSS REQUIRED FOR THIS SUBVIEW CONTENTS-->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/styles-responsive.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-style8.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>
		<!-- end: CORE CSS -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		
				
				
		
		<div class="main-wrapper">
			<!-- start: TOPBAR -->
			<header class="topbar navbar navbar-inverse navbar-fixed-top inner">
				<!-- start: TOPBAR CONTAINER -->
				<div class="container">
					<div class="navbar-header">
						<a class="sb-toggle-left hidden-md hidden-lg" href="#main-navbar">
							<i class="fa fa-bars"></i>
						</a>
						<!-- start: LOGO -->
						<a class="navbar-brand" href="">
							<img src="assets/images/logo.png" alt="Rapido"/>
						</a>
						<!-- end: LOGO -->
					</div>
					</div>
				</div>
				<!-- end: TOPBAR CONTAINER -->
			</header>
			<!-- end: TOPBAR -->

			
			<!-- start: MAIN CONTAINER -->
			<div class="main-container inner">
				<!-- start: PAGE -->
				<div class="main-content">
				
					<div class="container">
						<!-- start: PAGE HEADER -->
						<!-- start: TOOLBAR -->
						<div class="toolbar row">
							<div class="col-sm-6 hidden-xs">
								<div class="page-header">
									<h1>SAFE PAL FORM<small>survivor report</small></h1>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12">
								<a href="#" class="back-subviews">
									<i class="fa fa-chevron-left"></i> BACK
								</a>
								<a href="#" class="close-subviews">
									<i class="fa fa-times"></i> CLOSE
								</a>
								<div class="toolbar-tools pull-right">
									<!-- start: TOP NAVIGATION MENU -->
									<ul class="nav navbar-right">
																		</div>
							</div>
						</div>
						<!-- end: TOOLBAR -->
						<!-- end: PAGE HEADER -->

						<!-- start: BREADCRUMB -->
						<div class="row">
							<div class="col-md-12">
								<ol class="breadcrumb">
									<li>
										<a href="#">
											Dashboard
										</a>
									</li>
									<li class="active">
										Form Validation
									</li>
								</ol>
							</div>
						</div>
						<!-- end: BREADCRUMB -->
						<!-- start: PAGE CONTENT -->
						<div class="row">
							<div class="col-md-12">
								<!-- start: FORM VALIDATION 1 PANEL -->
								<div class="panel panel-white">
									<div class="panel-heading">
										<h4 class="panel-title">Safe Pal <span class="text-bold">Report</span></h4>
										<div class="panel-tools">
											<div class="dropdown">
												
											</div>
											
										</div>
									</div>
									<div class="panel-body">
										<h2><i class="fa fa-pencil-square"></i> REPORT </h2>
										<p>
											report all cases about Gender Based Violence towards you or your friend so that you get HELP. 
										</p>
										<hr>
										<form name="form" method="post" action="" enctype="multipart/form-data" >
											<div class="row">
												<div class="col-md-12">
													<div class="errorHandler alert alert-danger no-display">
														<i class="fa fa-times-sign"></i> You have some form errors. Please check below.
													</div>
													<div class="successHandler alert alert-success no-display">
														<i class="fa fa-ok"></i> Your form validation is successful!
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															Phone Number <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="Insert your phone number" class="form-control"  name="ei_phoneNumber">
													</div>
                                                    
                                                    <div class="form-group">
														<label class="control-label">
															Gender <span class="symbol required"></span>
														</label>
														<div>
															<label class="radio-inline">
																<input type="radio" class="grey" value="" name="ei_gender" id="gender_female">
																Female
															</label>
															<label class="radio-inline">
																<input type="radio" class="grey" value="" name="ei_gender"  id="gender_male">
																Male
															</label>
														</div>
													</div>
                                                    
													<div class="form-group">
														<label class="control-label">
															Age <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="How old are you?" class="form-control" name="ei_age">
													</div>
													<div class="form-group">
														<label class="control-label">
															Location <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="where did it happen from?" class="form-control" name="ti_locations">
													</div>
													
												</div>
												<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                        Incident date <span class="symbol required"></span>
                                                        </label>
											
										
										<div class="input-group">
											<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" name="ti_date" class="form-control date-picker">
											<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
										</div>
																										</div>
                                                    
                                                    <div>
                                                    </div>
													<div class="form-group">
														
											incident Time <span class="symbol required"></span>
										
										<div class="input-group input-append bootstrap-timepicker">
											<input type="text" name="ti_time" class="form-control time-picker">
											<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
										</div>
													</div>
                                                    
													<div class="row">
														<div class="col-md-12" >
                                                            <div class="form-group">
											<label for="form-field-24">
												Incident Description <span class="symbol required"></span>
											</label>
											<textarea name="ti_description" placeholder="tell us more about what excatly happened" class="autosize form-control" id="form-field-24"></textarea>
										</div>
														</div>
														
													</div>
                                                    
													<div class="form-group">
														<label class="control-label">
															Type of Incident <span class="symbol required"></span>
														</label>
														<select class="form-control"  name="ti_type">
															<option value="">Select...</option>
															<option value="Category 1">Rape(includes gang rape, marital rape)</option>
															<option value="Category 2">Sexual Assalt(icludes attempted rape, sexual violence)</option>
															<option value="Category 3">Physical Assault(includes hitting, slapping,kicking)</option>
															<option value="Category 4">Forced marriage(includes early marriage)</option>
                                                            <option value="Category 5">Denial of Resources, opportunities and services</option>
                                                            <option value="Category 6">Psychological Abuse</option>
                                                            <option value="Category 7">Femal Genital cutting/ mutilation</option>
                                                            <option value="Category 8">others</option>
														</select>
													</div>
												</div>
											</div>
                                            <div class="row">
                                            <div class="col-md-12">
                                                	<div class="form-group">
														<label class="control-label">
															Action Taken <em>(select the action you have taken)</em> <span class="symbol required"></span>
														</label>
														<div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Legal service Center" name="services[]" id="services[]">
																	Legal service Center
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Police" name="services[]"  id="services[]">
																	Police
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="livelihoods Program" name="services[]"  id="services[]">
																	livelihoods Program
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Local Council officials" name="services[]"  id="services[]">
																	Local Council officials
																</label>
															</div>
                                                            
                                                            <div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Safe Shelter" name="services[]"  id="services[]">
																	Safe Shelter
																</label>
															</div>
                                                            
                                                            <div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Health Care" name="services[]"  id="services[]">
																	Health Care
																</label>
															</div>
                                                            
                                                            <div class="checkbox">
																<label>
																	<input type="checkbox" class="grey" value="Not yet" name="services[]"  id="services[]">
																	Not yet
																</label>
															</div>
                                                            
														</div>
													</div>
                                                
                                                </div>
                                            </div>
											<div class="row">
												<div class="col-md-12">
													<div>
														<span class="symbol required"></span>Required Fields
														<hr>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-8">
													<p>
														By clicking REGISTER, you are agreeing to the Policy and Terms &amp; Conditions.
													</p>
												</div>
												<div class="col-md-4">
													<button class="btn btn-yellow btn-block" name="submit" type="submit">
														Register <i class="fa fa-arrow-circle-right"></i>
													</button>
												</div>
											</div>
										</form>
										</form>
									</div>
								</div>
								<!-- end: FORM VALIDATION 1 PANEL -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
							</div>
						</div>
						<!-- end: PAGE CONTENT-->
					</div>
					<div class="subviews">
						<div class="subviews-container"></div>
					</div>
				</div>
				<!-- end: PAGE -->
			</div>
			<!-- end: MAIN CONTAINER -->
			<!-- start: FOOTER -->
			<footer class="inner">
				<div class="footer-inner">
					<div class="pull-left">
						2016 &copy; Safe Pal.
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="fa fa-chevron-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->
			<!-- start: SUBVIEW SAMPLE CONTENTS -->
			<!-- *** NEW NOTE *** -->
			
			
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="assets/plugins/jQuery/jquery-1.11.1.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
		<!--<![endif]-->
		<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="assets/plugins/moment/min/moment.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="assets/plugins/bootbox/bootbox.min.js"></script>
		<script src="assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js"></script>
		<script src="assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js"></script>
		<script src="assets/plugins/jquery.appear/jquery.appear.js"></script>
		<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="assets/plugins/velocity/jquery.velocity.min.js"></script>
		<script src="assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
		<script src="assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
		<script src="assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script src="assets/plugins/toastr/toastr.js"></script>
		<script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src="assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
		<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
		<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		
		<script src="assets/plugins/truncate/jquery.truncate.js"></script>
		<script src="assets/plugins/summernote/dist/summernote.min.js"></script>
		<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="assets/js/subview.js"></script>
		<script src="assets/js/subview-examples.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="assets/plugins/ckeditor/ckeditor.js"></script>
		<script src="assets/plugins/ckeditor/adapters/jquery.js"></script>
		<script src="assets/js/form-validation.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE JAVASCRIPTS  -->
		<script src="assets/js/main.js"></script>
		<!-- end: CORE JAVASCRIPTS  -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				SVExamples.init();
				FormValidator.init();
			});
		</script>
	</body>
	<!-- end: BODY -->

<!-- Mirrored from www.cliptheme.com/demo/rapido/form_validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 17 Feb 2016 11:59:29 GMT -->
</html>