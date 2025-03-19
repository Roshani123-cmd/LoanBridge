<?php $this->load->view('commen1/header2')?>
<style>
.required {
    color: red
}
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php $this->load->view('commen1/sidebar2')?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <!-- End of Topbar -->
                <?php $this->load->view('commen1/navbar2')?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            <?= $heading; ?>
                        </h1>
                        <a class="btn btn-primary" href="<?= site_url('Dashboard'); ?>">Back Button</a>
                    </div>
                    <!-- Content Row -->
                    <div class="col-md-12" style="pointer-events:none;">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bank_id">Bank </label>
                                <select name="bank_id" class="form-control" id="bank_id">
                                    <option value="">Select Bank</option>
                                    <?php foreach ($GetBank as $Bankrow) {  ?>
                                    <option value="<?= $Bankrow->id; ?>"
                                        <?= ($getData->bank_id == $Bankrow->id) ? 'selected' : ''; ?>>
                                        <?= $Bankrow->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="loan_type">Loan Type </label>
                                <select class="form-control" id="loan_type" name="loan_type">
                                    <option value="">Select Loan Type </option>
                                    <?php foreach ($GetLoans as $Bankrow) {  ?>
                                    <option value="<?= $Bankrow->id; ?>"
                                        <?= ($getData->loan_type == $Bankrow->id) ? 'selected' : ''; ?>>
                                        <?= $Bankrow->loan_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="loan_type_detail">
                            <div class="form-group col-md-6">
                                <label for="Loan_amount">Loan Amount </label>
                                <input type="text" class="form-control" id="loan_amount" name="loan_amount"
                                    placeholder="Enter Loan Amount" maxlenght="5" value="<?= $getData->loan_amount; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="interest_rate">Interest Rate(%)</label>
                                <input type="text" class="form-control" id="interest_rate" name="interest_rate"
                                    placeholder="Enter Interest Rate" readonly maxlenght="2"
                                    value="<?= $getData->interest_rate; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tennure">Tennure (In Months) </label>
                                <input type="text" class="form-control" id="tennure" name="tennure"
                                    placeholder="Enter Tennure" readonly maxlenght="2"
                                    value="<?= $getData->tennure; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tennure">Status</label><br />
                                <?php if($getData->status=='Approved'){ ?>
                                <span class="badge badge-success"><?= $getData->status; ?></span>
                                <?php }else if($getData->status=='Paid') { ?>
                                <span class="badge badge-info"><?= $getData->status; ?></span>
                                <?php }else{ ?>
                                <span class="badge badge-warning"><?= $getData->status; ?></span>
                                <?php } ?>
                            </div>
                            <div class="col-md-12" style="text-align:center">
                                <div>
                                    <h2><b>EMI Amount</b></h2>
                                    <h3 id="loan_emi">Rs. <?= $getData->emi_amount; ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Interest</b></h2>
                                    <h3 id="total_interest_rate">Rs. <?= $getData->monthly_interest_rate; ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Processing Fee</b></h2>
                                    <h3 id="processing_fee">Rs. <?= $getData->processing_fee; ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Payment</b></h2>
                                    <h3 id="total_payment">Rs. <?= $getData->total_payable; ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Paid Amount</b></h2>
                                    <h3 id="total_payment_paid">Rs. <?= $total_paid; ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Remaining Amount</b></h2>
                                    <h3 id="total_payment_remaining">Rs. <?= $total_rem; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($getEmiData))  {?>
                    <div class="col-md-12" style="text-align:center">
                        <table class="table table-striped">
                            <thead>
                                <th>Sr No</th>
                                <th>per month EMI Date</th>
                                <th>Paid Amount (Rs)</th>
                                <th>Payment Done Date Time</th>
                                <th>Payment Done</th>
                            </thead>
                            <tbody>
                                <?php $sr=1; foreach($getEmiData as $emiData) { ?>
                                <tr>
                                    <td><?= $sr; ?></td>
                                    <td><?= $emiData->emi_date; ?></td>
                                    <td><?= $emiData->paid_amount; ?></td>
                                    <td><?= $emiData->payment_done_datetime; ?></td>
                                    <?php if($emiData->payment_done=='Yes'){ ?>
                                    <td><a><span class="badge badge-success"><?= $emiData->payment_done; ?></span></a>
                                    </td>
                                    <?php }else{ ?>
                                    <td><a <?php if($getData->status=='Approved' && isset($_SESSION['user_type']) && $_SESSION['user_type']=='Customer' )  { ?>
                                            onclick="openStatusModal('<?= $emiData->edit_id ?>');"
                                            <?php } ?>style="cursor:pointer"><span
                                                class="badge badge-warning"><?= $emiData->payment_done; ?></span></a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php $sr++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <?php $this->load->view('commen1/footer2')?>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="modal  fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <form method="POST" action="<?= site_url('Dashboard/changeStatusEmiPay') ?>">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Status Of Loan EMi</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="Yes" selected>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount"
                                        placeholder="Enter Amount" maxlength="7" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="req_id" />
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
        function openStatusModal(id) {
            $('#req_id').val(id);
            $('#statusModal').modal('show');

        }
        </script>
</body>