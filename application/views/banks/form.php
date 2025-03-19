<?php $this->load->view('commen1/header2'); ?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php $this->load->view('commen1/sidebar2')?>
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php $this->load->view('commen1/navbar2')?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="page-title"><?= $heading; ?></h1>
                                    <form method="post" action="<?= $action;?>">
                                        <input type="hidden" id="city_id" name="user_id">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label><span class="text text-danger"> *
                                                <?= form_error('name') ?></span>
                                            <input type="text" class="form-control" name="name" id="exampleInputName1"
                                                placeholder="Name" value="<?= !empty($name) ? $name : ''; ?>"
                                                autocomplete="off" maxlength="70">
                                        </div>
                                        <!-- <div class="form-group">
                                        <label for="exampleInputName2">Branch Name</label><span
                                            class="text text-danger"> *
                                            <?= form_error('branch_name') ?></span>
                                        <input type="text" class="form-control" name="branch_name"
                                            id="exampleInputName2" placeholder="Branch Name"
                                            value="<?= !empty($branch_name) ? $branch_name : ''; ?>" autocomplete="off"
                                            maxlength="70">
                                    </div> -->
                                        <div class="form-group">
                                            <label for="exampleInputName3">IFSC Code</label><span
                                                class="text text-danger">
                                                *
                                                <?= form_error('ifsc_code') ?></span>
                                            <input type="text" class="form-control" name="ifsc_code"
                                                id="exampleInputName3" placeholder="IFSC Code"
                                                value="<?= !empty($ifsc_code) ? $ifsc_code : ''; ?>" autocomplete="off"
                                                maxlength="11" minlength="11">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label><span class="text text-danger"> *
                                                <?= form_error('status') ?></span>
                                            <div class="push-left">
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="Active"
                                                        <?= !empty($status) && $status == 'Active' ? 'checked' : ''; ?>>
                                                    Active
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="Block"
                                                        <?= !empty($status) && $status == 'Block' ? 'checked' : ''; ?>>
                                                    Block
                                                </label>
                                            </div>
                                        </div>

                                        <button type="submit" name="create"
                                            class="btn btn-success btn-sm"><?= $button; ?></button>
                                        <button type="button" name="cancel" class="btn btn-danger btn-sm"
                                            onclick="window.location='<?= $cancel_action; ?>'"><?= $cancel; ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Import Section -->

                    <!-- End of Import Section -->
                </div>
            </div>
            <?php $this->load->view('commen1/footer2') ?>
        </div>
        <!-- Begin Page Content -->


    </div>
</body>

</html>