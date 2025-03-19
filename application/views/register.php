<?php $this->load->view('commen1/header3'); ?>
<style>
.password {
    position: relative;
}

.input-group-text {
    border-radius: 10rem;
    position: absolute;
    top: 11px;
    right: 17px;
    border: 0px;
    background-color: white;
}
</style>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6">
                        <img src="<?=  base_url('assets/img/login_img.jpg'); ?>" width="100%" style="object-fit:cover"
                            height="100%" />
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <b>
                                    <h1 class="h4 text-gray-900 mb-4">Registration Form</h1>
                                </b>
                            </div>
                            <form class="user" method="post" action="<?= $register_button_action ?>">

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-user"
                                        id="examplefname" value="<?= !empty($name) ? $name : ''; ?>" placeholder="Name"
                                        maxlength="40" autocomplete="off">
                                    <span><?= form_error('name'); ?></span>
                                </div>


                                <div class="form-group">
                                    <input type="text" name="email_address" class="form-control form-control-user"
                                        id="examplefname" value="<?= !empty($email_address) ? $email_address : ''; ?>"
                                        placeholder="Email ID">
                                    <span><?= form_error('email_address'); ?></span>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0 password">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="examplepassword" value="<?= !empty($password) ? $password : ''; ?>"
                                            placeholder="Password" autocomplete="off">
                                        <span class="input-group-text" onclick="showhidepassword()">
                                            <i class="fa fa-eye" id="togglepassword" style="cursor: pointer"></i>
                                        </span>
                                        <span><?= form_error('password'); ?></span>
                                    </div>
                                    <div class="col-sm-6 password">
                                        <input type="password" name="repeatpassword"
                                            class="form-control form-control-user" id="examplerepeatpassword"
                                            value="<?= !empty($repeatpassword) ? $repeatpassword : ''; ?>"
                                            placeholder="Repeat Password" autocomplete="off">
                                        <span class="input-group-text" onclick="showhiderepeatpassword()">
                                            <i class="fa fa-eye" id="togglerepeatpassword" style="cursor: pointer"></i>
                                        </span>
                                        <span><?= form_error('repeatpassword'); ?></span>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn btn-primary btn-user btn-block"><?= $register_button; ?>
                                </button>


                            </form>
                            <hr>

                            <div class="text-center">
                                <a class="small" href="<?php echo site_url('welcome/index'); ?>">Already have an
                                    account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php $this->load->view('commen1/footer3'); ?>
    <script>
    function showhidepassword() {
        var checkClassType = $('#examplepassword').attr('type');
        if (checkClassType === 'password') {
            $('#examplepassword').prop('type', 'text');
            $('#togglepassword').prop('class', 'fa fa-eye-slash');
        } else {
            $('#examplepassword').prop('type', 'password');
            $('#togglepassword').prop('class', 'fa fa-eye');
        }
    }

    function showhiderepeatpassword() {
        var checkClassType = $('#examplerepeatpassword').attr('type');
        if (checkClassType === 'password') {
            $('#examplerepeatpassword').prop('type', 'text');
            $('#togglerepeatpassword').prop('class', 'fa fa-eye-slash');
        } else {
            $('#examplerepeatpassword').prop('type', 'password');
            $('#togglerepeatpassword').prop('class', 'fa fa-eye');
        }

    }
    </script>