<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
<footer class="footer">
  <div class="container-fluid clearfix text-center">
    <small class="text-white">Copyright &copy; <?php echo date('Y') ?> EngTech Global Solutions Inc.</small>
    <img class="pull-right img img-responsive" style="height:30px" src="<?php echo base_url('assets/img/web/ama-logo-sm.fw.png') ?>">
  </div>
</footer>
</div>

<div class="modal fade" id="modalChangePic" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-picture-o"></i> Change Profile Picture</h4>
      </div>
      <form method="post" id="formChangeImage" action="<?php echo base_url('settings/changeUserImage') ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div id="imageUploadError">

              </div>
              <img src="<?php echo base_url('assets/img/profile_image/' . $this->userInfo->user_image) ?>" id="imageUser" class="img img-responsive">
              <input type="file" id="inputfile" class="hide" name="user_image">
              <button id="btnbrowseimage" class="btn btn-sm btn-info m-t-10" type="button" style="width:100%">Browse Photo</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->

<script src="<?php echo base_url('assets/plugins/jquery/jquery-migrate-1.1.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/backbone/underscore.js'); ?>"></script>
<script src="<?php echo base_url('assets/backbone/backbone.js'); ?>"></script>
<script src="<?php echo base_url('assets/backbone/model.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-cookie/jquery.cookie.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/icheck/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/pnotify/pnotify.custom.min.js'); ?>"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar2/fullcalendar.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-form-validation/js/formValidation.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-form-validation/js/framework/bootstrap.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugins/mockjax/jquery.mockjax.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootbox.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/fullcalendar-rightclick.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/parsley/dist/parsley.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-wizard/js/bwizard.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/apps.min.js'); ?>"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
  function dd(data) {
    console.log(data);
  }
  $(document).ready(function () {
    App.init();
    // FormEditable.init();
  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
  // 	document.body.style.zoom="87%"
  // });

  $(function () {

    $(".select2").select2();

    $("button#btnbrowseimage").click(function () {
      $("input#inputfile[type=file][name=user_image]").click();
    });

    $("input#inputfile[type=file][name=user_image]").on("change", function () {
//    			dd(URL.createObjectURL(event.target.files[0]));
      $("img#imageUser").fadeIn(100).attr('src', URL.createObjectURL(event.target.files[0]));
    });

    $("#formChangeImage").on("submit", function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url('settings/changeUserImage') ?>",
        type: "POST",
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          if (data.result == true) {
            location.href = "<?php echo current_url(); ?>";
          } else {
            $("#imageUploadError").html("<div class=\"alert alert-danger\" role=\"alert\">" + data['result']['error'] + "</div>");
          }
        },
        error: function () {
          console.log("function error");
        }
      });
    });
  });
</script>
</body>
</html>

