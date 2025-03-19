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
                                <div class="row">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h1 class="card-title"><?= $page_title; ?></h1>
                                                <form method="post" action="<?= $action;?>">
                                                    <input type="hidden" id="city_id" name="user_id">
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Bank Name</label><span
                                                            class="text text-danger">
                                                            *
                                                            <?= form_error('bank_id') ?></span>
                                                        <select class="form-control" name="bank_id"
                                                            id="exampleInputName1">
                                                            <option value="">Select Bank</option>
                                                            <?php if(!empty($allBanks)) {
                                                 foreach($allBanks as $bankData) {
                                                 ?>
                                                            <option value="<?= $bankData->id ?>"
                                                                <?= ($bank_id==$bankData->id) ? 'selected':""; ?>>
                                                                <?= $bankData->name ?>
                                                            </option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName2">Loan Name</label><span
                                                            class="text text-danger">
                                                            *
                                                            <?= form_error('loan_name') ?></span>
                                                        <input type="text" class="form-control" name="loan_name"
                                                            id="exampleInputName2" placeholder="Loan Name"
                                                            value="<?= !empty($loan_name) ? $loan_name : ''; ?>"
                                                            autocomplete="off" maxlength="70">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName3">Interst Rate %</label><span
                                                            class="text text-danger">
                                                            *
                                                            <?= form_error('interest_rate') ?></span>
                                                        <input type="text" class="form-control" name="interest_rate"
                                                            id="exampleInputName3" placeholder="Interst Rate"
                                                            value="<?= !empty($interest_rate) ? $interest_rate : ''; ?>"
                                                            autocomplete="off" maxlength="4">
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
                                                                <input type="radio" name="status" value="Inactive"
                                                                    <?= !empty($status) && $status == 'Inactive' ? 'checked' : ''; ?>>
                                                                Inactive
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