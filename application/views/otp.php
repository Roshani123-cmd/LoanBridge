<?php $this->load->view('commen1/header1'); ?>
<style>
.container {
    position: relative;
}

#loader {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: #4e73df;
    opacity: 0.35;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<body class="bg-gradient-primary">
    <div class="container">
        <div id="loader" style="display:none"><img src="<?= base_url('assets/img/loading-gif.webp') ?>" width="100%"
                height="100px" style="object-fit:contain" /></div>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image image-responsive">
                                <img src="<?=  base_url('assets/img/login_img.jpg'); ?>" width="100%"
                                    style="object-fit:cover" height="100%" />
                            </div>
                            <div class=" col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <b>
                                            <h1 class="h4 text-gray-900 mb-4">Welcome to Our LoanBridge!</h1>
                                        </b>
                                    </div>
                                    <form class="user" method="post" action="<?= $action; ?>">
                                        <div class="form-group">
                                            <b><label>OTP</label></b>
                                            <input type="text" name="otp" minlength="4" maxlength="4"
                                                class="form-control form-control-user"
                                                value="<?= !empty($otp) ? $otp : ''; ?>" placeholder="Enter OTP"
                                                autocomplete="off" />
                                            <span class="text text-danger"><?= form_error('otp'); ?> </span>
                                        </div>
                                        <input type="hidden" value="<?= $edit_id; ?>" name="edit_id" />
                                        <button type="submit"
                                            class="btn btn-primary btn-user btn-block"><?= $login_button; ?></button>
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <p id="time">Time Remaining : <b id="timer">00:60</b></p>
                                        <div><a class="small" href="javascript:void(0);" style="display:none;"
                                                id="resendOTP" onclick="sendOTP()">Resend OTP</a></div>
                                        <div><a class="small" href="<?php echo site_url('Welcome'); ?>">Back to
                                                login !</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <!-- btn btn-primary btn-user btn-block -->

</body>

<?php $this->load->view('commen1/footer1'); ?>
<script>
$(document).ready(function() {
    var time = 60;
    const myInterval = setInterval(function() {
        time--;
        if (time < 0) {
            clearInterval(myInterval);
            $('#resendOTP').show();
            $('#time').hide();
        } else {
            if (time.toString().length == 1) {
                $('#timer').text('00:0' + time);
            } else {
                $('#timer').text('00:' + time);
            }
        }
    }, 1000);
});

function sendOTP() {
    var site_url = '<?= site_url(); ?>';
    $('#loader').show();
    $.ajax({
        method: 'POST',
        url: site_url + '/Welcome/sendOTP',
        data: 'edit_id=' + '<?= $edit_id; ?>',
        success: function(
            response) {
            var obj = $.parseJSON(
                response);
            if (obj.success == '1') {
                toastr.success(obj.message);
            } else {
                toastr.error(obj.message);
            }
            $('#loader').hide();
        }
    });
}
</script>