<!-- BEGIN FOOTER -->
<div class="footer">
	<div class="footer-inner">
		 2017 &copy; Muneeb Ahmad Faruqi
	</div>
	<div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>

<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>

<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/scripts/core/app.js" type="text/javascript"></script>
<script src="assets/scripts/custom/index.js" type="text/javascript"></script>
<script src="assets/scripts/custom/tasks.js" type="text/javascript"></script>



<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   App.init(); // initlayout and core plugins
   Index.init();
   
   Tasks.initDashboardWidget();
/*Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Index.initDashboardDaterange();
   Index.initIntro();*/


   //get patient and show in the modal form
            $(document).on('click','#btn_edit_post',function(e){
                e.preventDefault();
                var p_id= $(this).data('id');
                $.ajax({
                  type: 'POST',
                  url: 'posts.php?query=get',
                  data: "p_id="+p_id,
                  dataType: 'json',
                success: function(data){
                  //var result= JSON.parse(data);
                  console.log(data);
                  $("#pst_id").val(data.post_id);
                  $("#pst_title").val(data.post_title);
                  $("#pst_content").val(data.post_content);
                  $("#pst_image").attr('src',data.post_pic);
                  $("#pst_date_Time").val(data.data_time);
                },
                error: function(data){
                  $('.modal-body').html('<i class="glyphicon glyphicon-info-sign"></i>'+data.message);
                }
                });

            });
   //update patient
            $(document).on('click','#btnUpdatePost',function(e){
              e.preventDefault();
              //console.log($("#frmUpdatePost").serialize());
              //return false;
              
 //             var formData = new FormData(this);

   //           console.log(formData);
              $.ajax({
                  type: 'POST',
                  url: 'posts.php?query=update',
                  data: $('#frmUpdatePost').serialize(),
                  async: false,
                  cache: false,
                  dataType: 'json',
                  success: function(data){
                    //var response= JSON.parse(data);
                    console.log(data);
                    if(data.status==='true'){
                    $(".modal-body").html('<i class="fa fa-info"></i>'+data.message);
                    $('#getPost').on('hidden.bs.modal', function () {
                       window.location.reload();
                     });
                    }
                    else if(data.status==='false')
                    $(".modal-body").html('<i class="fa fa-info"></i>'+data.message);
                  },
                  error: function(data){
                    //var response= JSON.parse(data);
                    console.log(data);
                    $(".modal-body").html('<i class="fa fa-info"></i>'+data.message);
                  }
              });
            });
            //Delete Patient
            $(document).on('click',"#btn_del_post",function(e){
              e.preventDefault();
              var p_id= $(this).data('id');
              $("#delPost").modal('show');
              $('#del_post_id').val(p_id);
              console.log("id to delete:"+p_id);
            });
            $(document).on('click',"#btnDelPost",function(e){
              e.preventDefault();
                $.ajax({
                  type: 'POST',
                  url: 'posts.php?query=delete',
                  data: "pt_id="+$('#del_post_id').val(),
                  async: false,
                  cache: false,
                  dataType: 'json',
                  success: function(data){
                    //var response= JSON.parse(data);
                    console.log(data);
                    if(data.status==='true'){
                    $(".modal-body").html('<i class="fa fa-info"></i>'+data.message);
                    $("#delFooter").remove();
                    $('#delPost').on('hidden.bs.modal', function () {
                       window.location.reload();
                     });
                    }
                    else if(data.status==='false'){
                       $(".modal-body").html('<i class="fa fa-info"></i>'+data.message);
                       $("#delFooter").remove();
                    }
                  },
                  error: function(data){
                    //var response= JSON.parse(data);
                    console.log(data);
                    $(".modal-body").html('<i class="fa fa-info"></i>' +data.message);
                    $("#delFooter").remove();
                  }
                });
            });

});

// Edit post...

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>