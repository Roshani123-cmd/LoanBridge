<?php $this->load->view('commen1/header1'); ?>
<style>
.password {
    position: relative;
}

.input-group-text {
    border-radius: 10rem;
    position: absolute;
    top: 43px;
    right: 10px;
    border: 0px;
    background-color: white;
}
</style>

<body class="bg-gradient-primary">

    <div class="container">

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
                                            <b><label>Email</label></b>
                                            <input type="email" name="email_address" minlength="20"
                                                class="form-control form-control-user"
                            
                                                placeholder="Email" autocomplete="off" />
                                            <span class="text text-danger"><?= form_error('email_address'); ?> </span>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary btn-user btn-block"><?= $login_button; ?></button>
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo site_url('Welcome'); ?>">Back to login</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo site_url('Welcome/register'); ?>">Create an
                                            Account!</a>
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
