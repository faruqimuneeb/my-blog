<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['email'])){

		header('location: login.php');
		session_unset();
	}

	include 'include/header_dashboard.php';
	include 'include/dbcon.php';

	$target_dir= "uploads/";
	$u_id= $_SESSION['id'];
	if(isset($_POST['btn_submit_post'])){

		$target_file =  basename($_FILES["img_to_upload"]["name"]);
		//$image= mysqli_real_escape_string($link,trim($_FILES['img_to_upload']['basename']));
		$post_title= mysqli_real_escape_string($link,trim($_POST['post_title']));
		$post_content =mysqli_real_escape_string($link,trim($_POST['post_content']));
		if(!empty($target_file)){

			$target_path= $target_dir.$target_file;
			if(move_uploaded_file($_FILES['img_to_upload']['tmp_name'], $target_path))
			{
				
				$sql_save_post= "INSERT INTO tbl_posts (post_title, post_content, post_pic,u_id) VALUES ('$post_title','$post_content','$target_path','$u_id')";
				$res_sql_save_post= mysqli_query($link,$sql_save_post);
				if($res_sql_save_post){
					$_GET['msg']= true;
				}else{
					$_GET['msg']= false;
				}
			}
		}
	}
	
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
					Posts <small>New post</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a >
								Posts
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<i class="fa fa-plus"></i><a href="new_post.php">
								New Post
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
			<div class="row">
				<?php
					if(isset($_GET['msg']) && $_GET['msg']){
						?>
							<div class="alert alert-success">
								<button class="close" data-close="alert"></button>
								Post saved successfully.
							</div>
						<?php
					}else if( isset($_GET['msg']) && !$_GET['msg'] ){
						?>
							<div class="alert alert-danger">
								<button class="close" data-close="alert"></button>
								Post not saved. Please go back and look at the data you entered.
							</div>
						<?php
					}
				?>
				<!-- BEGIN Portlet PORTLET-->
				<div class="portlet box grey">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-plus"></i>Add post
						</div>
					</div>
					<div class="portlet-body form">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">Post Image</label>
									<div class="col-md-6">
										<input type="file" accept="image/jpeg/png" name="img_to_upload" class="form-control">
									</div>
									<div class="col-md-3">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Post Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="post_title" placeholder="Post title here">
									</div>
									<div class="col-md-3">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Post Body</label>
									<div class="col-md-6">
										<textarea  class="form-control" name="post_content" placeholder="Post content/body here"></textarea>
									</div>
									<div class="col-md-3">
									</div>
								</div>
								</div>
								<div class="form-actions right">
									<div class="col-md-3"></div>
									<div class="col-md-6">
										<button type="reset" name="btn_cancel" class="btn red">Cancel</button>
										<button type="submit" name="btn_submit_post" class="btn blue">Submit</button>
									</div>
									<div class="col-md-3"></div>
								</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include 'include/footer_dashboard.php';
?>