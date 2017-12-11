<?php
	
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['email'])){

		header('location: login.php');
		session_unset();
	}

	include 'include/header_dashboard.php';
	include 'include/dbcon.php';

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
					Posts <small>Edit a post</small>
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
							<i class="fa fa-pencil"></i><a href="edit_post.php">
								Edit Post
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
								Post saved successfully.
							</div>
						<?php
					}else if( isset($_GET['msg']) && !$_GET['msg'] ){
						?>
							<div class="alert alert-danger">
								Post not saved. Please go back and look at the data you entered.
							</div>
						<?php
					}
				?>
				<!-- BEGIN Portlet PORTLET-->
				<div class="portlet box grey">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-plus"></i>Vew/Edit post
						</div>
					</div>

					<div class="portlet-body">
							<!-- get posts of a specific user and show in table -->
							<?php 
								$u_id= $_SESSION['id'];
								$sql_get_posts ="SELECT post_id,post_title,post_content,post_pic, data_time FROM tbl_posts where u_id='$u_id'";
								
								$res_sql_get_posts= mysqli_query($link,$sql_get_posts);
								if(mysqli_num_rows($res_sql_get_posts)>0){
							?>
							<table class="table table-striped table-bordered table-hover dataTable" id="sample_1">
								<thead>
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Content</th>
										<th>Image</th>
										<th>Date Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php // while loop to get posts
										while ($data= mysqli_fetch_assoc($res_sql_get_posts)) {
											
										
									?>
									<tr>
										<td><?php echo $data['post_id']; ?></td>
										<td><?php echo $data['post_title']; ?></td>
										<td><?php echo $data['post_content']; ?></td>
										<td><img src='<?php echo $data["post_pic"]; ?>' style="width: 30px; height: 30px;"></td>
										<td><?php echo $data['data_time']; ?></td>
										<td>
											<a class="btn btn-primary" id="btn_edit_post" href="#getPost" data-id="<?php echo $data['post_id'];?>" data-toggle="modal"><i class="fa fa-pencil"></i></a>
	                                      <a class="btn btn-danger" id="btn_del_post"  data-id="<?php echo $data['post_id'];?>" data-toggle="modal"><i class="fa fa-trash-o"></i></a>
										</td>
									</tr>
								</tbody>
								<?php
									}// end while loop
								?>
							</table>
							<?php
							}
							?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include 'include/footer_dashboard.php';
?>



<!--Update Post-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="getPost" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">View/Update Post</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" id="frmUpdatePost" enctype="multipart/form-data">
            <input type="hidden" class="form-control" id="pt_id" name="pt_id">
          <div class="form-group">
            <label for="pst_id">ID</label>
            <input type="text" readonly="readonly" class="form-control" id="pst_id" name="pst_id">
          </div>
          <div class="form-group">
            <label for="pst_title">Title</label>
            <input type="text" class="form-control" id="pst_title" name="pst_title">
          </div>
          <div class="form-group">
            <label for="pst_content">Content</label>
            <textarea name="pst_content" id="pst_content" class="form-control">
            </textarea>
          </div>
          
          <div class="form-group">
            <label for="pst_image">Image</label>
            <img src="" id="pst_image" name="pst_image" />
          </div>


          <div class="form-group">
            <label for="pst_date_Time">Post Time/Date</label>
            <input type="text" readonly="readonly" class="form-control" id="pst_date_Time" name="pst_date_Time" >
          </div>
          </form>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-lg btn-danger" type="button">Close</button>
            <button type="submit" name="btnUpdatePost" id="btnUpdatePost" class="btn btn-lg btn-success">Save</button>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Deletion-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="delPost" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Delete Post</h4>
      </div>
      <div class="modal-body">
          Are you sure to delete post?
          <input type="hidden" name="del_post_id" id="del_post_id">
      </div>
      <div class="modal-footer" id="delFooter">
      <button class="btn btn-primary" type="button" id="btnDelPost">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Deletion Ends-->