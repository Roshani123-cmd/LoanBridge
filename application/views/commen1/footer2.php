 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Your Website 2021</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
             <div class="modal-footer">
                 <a class="btn btn-primary" href="<?= site_url('Welcome') ?>">Logout</a>
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
             </div>
         </div>
     </div>
 </div>
 <div class="modal" id="notice_popup" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="notice_popup_title">Notice</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body" id="notice_popup_description">
             </div>
         </div>
     </div>
 </div>
 <!-- Bootstrap core JavaScript-->
 <script src=<?= base_url()."assets/vendor/jquery/jquery.min.js"?>></script>
 <script src=<?= base_url()."assets/vendor/bootstrap/js/bootstrap.bundle.min.js"?>></script>

 <!-- Core plugin JavaScript-->
 <script src=<?= base_url()."assets/vendor/jquery-easing/jquery.easing.min.js"?>></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <!-- njavascript start -->
 <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">
// Default Configuration
$(document).ready(function() {
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': false,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '1000',
        'hideDuration': '1000',
        'timeOut': '5000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
});
// Toast Type
<?php if(!empty($this->session->flashdata('success'))) { ?>
toastr.success("<?= $this-> session->flashdata('success') ?>");
<?php } ?>
<?php if(!empty($this->session->flashdata('error'))) { ?>
toastr.error("<?= $this-> session->flashdata('error') ?>");
<?php } ?>

function openNoticePopUp(id, title, description) {
    $('#notice_popup_description').html(description);
    $('#notice_popup_title').html(title);
    $('#notice_popup').modal('show');
    $.ajax({
        type: 'POST',
        url: '<?= site_url('Dashboard/seenNotification') ?>',
        data: "id=" + id,
        cache: false,
        success: function(response) {
            var obj = JSON.parse(response);
            if (obj.success == '1') {
                toastr.success("Notice seen successfully");
                $('#noti_data').html(obj.html);
                $('#noti_count').html(obj.count);
            } else {
                toastr.error("Data not found");
            }
        }
    });
} 

 </script>
