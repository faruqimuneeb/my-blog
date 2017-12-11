<?php
	session_start();
	if(!isset($_SESSION['id']) && !isset($_SESSION['user_id'])){

		session_unset();
		session_destroy();
		header('location:index.php');

	}
	$u_id= $_SESSION['id'];
	header('Content-type: application/json; charset=UTF-8');
	require_once("include/dbcon.php");

	$query = isset($_GET['query']) ? $_GET['query'] : false;

	switch ($query) {
		case 'get':
			{

				$p_id=mysqli_real_escape_string($link,trim($_POST['p_id']));
				
		        $sql="SELECT post_id, post_title, post_content, post_pic, data_time FROM tbl_posts WHERE post_id='$p_id' AND u_id='$u_id'";
		        $sqlResult= mysqli_query($link,$sql);
		        if(mysqli_num_rows($sqlResult)>0){
		        	$resSet=mysqli_fetch_assoc($sqlResult);
					//$resArray= array_map("utf8_encode", $resSet);
					echo json_encode($resSet);
					exit;
        		}
			}
			break;
		case 'update':
			{
				$target_dir= "uploads/";
				//$target_file =  basename($_FILES["pst_new_image"]["name"]);
				//$image= mysqli_real_escape_string($link,trim($_FILES['img_to_upload']['basename']));
				$post_id= mysqli_real_escape_string($link,trim($_POST['pst_id']));
				$post_title= mysqli_real_escape_string($link,trim($_POST['pst_title']));
				$post_content =mysqli_real_escape_string($link,trim($_POST['pst_content']));

					
							$sql_update_post= "UPDATE tbl_posts SET post_title='$post_title', post_content='$post_content' WHERE u_id='$u_id' AND post_id='$post_id'";
						$res_sql_update_post= mysqli_query($link,$sql_update_post);
						if($res_sql_update_post){
							$data=  array('status' => 'true' , 'message' => 'Post #'. $post_id.' updated successfully' );
							echo json_encode($data);
							exit();
						}else{
							$data=  array('status' => 'false' , 'message' => 'Post #'. $post_id.' not updated. Try again later' );
							echo json_encode($data);
							exit();
						}
			}
			break;
		case 'delete':
			{
				$post_id= mysqli_real_escape_string($link,trim($_POST['pt_id']));
				$sql_delete= "DELETE FROM tbl_posts WHERE post_id='$post_id' AND u_id='$u_id'";
				$res_sql_delete = mysqli_query($link,$sql_delete);
				if($res_sql_delete){
				$data=  array('status' => 'true' , 'message' => 'Post deleted successfully' );
							echo json_encode($data);
							exit();
						}else{
							$data=  array('status' => 'false' , 'message' => 'Post not deleted. Try again later' );
							echo json_encode($data);
							exit();
						}
			}
			break;
		
		default:
			
			break;
	}


?>