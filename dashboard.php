<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['email'])){
		header('location: login.php');
		session_unset();
	}
	include 'include/dbcon.php';
	$sql_total_posts = "SELECT count(*) as total_posts FROM tbl_posts";
	$sql_new_posts ="SELECT count(*) as new_posts FROM tbl_posts WHERE DATE(data_time) = CURDATE()";

	$res_sql_total_posts= mysqli_query($link,$sql_total_posts);
	
	$res_sql_new_posts= mysqli_query($link,$sql_new_posts);
	
	$data_total_posts= mysqli_fetch_assoc($res_sql_total_posts);
	$data_new_posts= mysqli_fetch_assoc($res_sql_new_posts);
	$total_posts = $data_total_posts['total_posts'];
	$new_posts= $data_new_posts['new_posts'];

	include 'include/header_dashboard.php';
?>
	<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php include 'include/sidebar_dashboard.php'; ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Dashboard <small>statistics and more</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="index.html">
								Home
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">
								Dashboard
							</a>
						</li>
						<li class="pull-right">
							<div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
								<i class="fa fa-calendar"></i>
								<span>
								</span>
								<i class="fa fa-angle-down"></i>
							</div>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $new_posts; ?>
							</div>
							<div class="desc">
								 New posts
							</div>
						</div>
						<a class="more" href="#">
							 <!-- View more <i class="m-icon-swapright m-icon-white"></i> -->
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 50
							</div>
							<div class="desc">
								New Comments
							</div>
						</div>
						<a class="more" href="#">
							 <!-- View more <i class="m-icon-swapright m-icon-white"></i> -->
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $total_posts; ?>
							</div>
							<div class="desc">
								 Total posts
							</div>
						</div>
						<a class="more" href="#">
							 <!-- View more <i class="m-icon-swapright m-icon-white"></i> -->
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 90
							</div>
							<div class="desc">
								 Total comments
							</div>
						</div>
						<a class="more" href="#">
							<!-- View more <i class="m-icon-swapright m-icon-white"></i> -->
						</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			<div class="clearfix">
			</div>

		</div>
	</div>
</div>


<?php
include 'include/footer_dashboard.php';
?>