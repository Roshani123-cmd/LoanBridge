<title><?= $page_title; ?></title>
<?php $this->load->view('common/header'); ?>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2"><?= $forgotpasswordheading; ?></h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <?php if (!empty($massage)) { ?>
                                    <div class="alert alert-danger">
                                        <?= $massage; ?>
                                    </div>
                                    <?php } ?>
                                    <form class="user" method="post" action="<?= $action; ?>">
                                        <div class="form-group">
                                            <?= form_error('email_address'); ?>
                                            <input type="text" class="form-control form-control-user"
                                                name="email_address" id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..."
                                                value="<?= isset($email_address) && !empty($email_address) ? $email_address : ''; ?>">
                                        </div>

                                        <a href="<?php echo site_url('Welcome/changenewpassword'); ?>"
                                            class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="panel-footer">
                                        <div>&nbsp; <br />
                                            <input type="hidden" id="site_url" value="<?= site_url(); ?>" />

                                            <button type="button" class="btn btn-primary btn-user btn-block"
                                                onclick="window.location='<?= $cancel_action; ?>'"><?= $cancel; ?></button>
                                            -
                                        </div>
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
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->

    <!-- Custom scripts for all pages-->
    <!-- <script src="js/sb-admin-2.min.js"></script> -->

    <!-- </body> -->

    <!-- </html> -->