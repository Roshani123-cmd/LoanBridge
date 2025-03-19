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
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?= $records; ?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <?php foreach ($Loandata as $customers) {
                                                     $bankName = 'Not Available';
                                                     $getBank = $this->Loan_model->GetData('mst_banks','','status="Active" and id="'.$customers->bank_id.'"','id DESC','','','1'); 
                                                     if(!empty($getBank)){
                                                         $bankName = $getBank->name;
                                                     }
                                                     ?>
                                                    <tr>
                                                        <td><strong>Bank Name</strong></td>
                                                        <td><?= $bankName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Name</strong></td>
                                                        <td><?= $customers->loan_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Interest Rate %</strong></td>
                                                        <td><?= $customers->interest_rate; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>
                                                            <?php if ($customers->status == "Active") { ?>
                                                            <span
                                                                class="badge badge-success"><?= $customers->status; ?></span>
                                                            <?php } elseif ($customers->status == "Inactive") { ?>
                                                            <span
                                                                class="badge badge-danger"><?= $customers->status; ?></span>
                                                            <?php } else { ?>
                                                            <span
                                                                class="badge badge-warning"><?= $customers->status; ?></span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <button type="button" name="cancel" class="btn btn-danger btn-sm"
                                                onclick="window.location='<?= $cancel_action; ?>'"><?= $cancel; ?></button>
                                        </div>
                                    </div>
                                </div>
                                <!--First table Ends -->
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