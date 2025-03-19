<?php $this->load->view('commen1/header2')?>
<style>
.required {
    color: red
}

/* CSS for event colors based on status */
.confirmed-event {
    background-color: green !important;
    color: white;
}

.pending-event {
    background-color: orange !important;
    color: black;
}

.canceled-event {
    background-color: red !important;
    color: white;
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
                        <h1 class="h3 mb-0 text-gray-800">Welcome
                            <b><?= (isset($_SESSION['name']) && !empty($_SESSION['name'])) ? $_SESSION['name'] :'Not Available'; ?></b>
                            !!!
                        </h1>
                        <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Customer' && count($checkRequest)==0) { ?>
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#requestForLoan">Request
                            For Loan</a>
                        <?php } ?>
                    </div>
                    <!-- Content Row -->
                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Employee') { ?>
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                                Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCustomer; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                                Customer Pending Loan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $totalCustomerPendingLoanRequest; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                                Customer Approved Loan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $totalCustomerApprovedLoanRequest; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                                Customer Rejected Loan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?= $totalCustomerRejectedLoanRequest; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <?php }?>
					<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Customer') {  ?>
                    <div class="row">
                        <!-- Pie Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Loan Compare List</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
								<table class="table table-bordered" id="exampleId">
									<thead>
											<th>SR No.</th>
											<th>Bank Name</th>
											<th>Loan Name</th>
											<th>Interest Rate (%)</th>
									</thead>
										<tbody>
											<?php if(!empty($allLoanType))  {?>
											<?php $i = 1; foreach ($allLoanType as $customerrow) {
												$bankName = 'Not Available';
												$getBank = $this->Dashboard_model->GetData('mst_banks','','status="Active" and id="'.$customerrow->bank_id.'"','id DESC','','','1'); 
												if(!empty($getBank)){
													$bankName = $getBank->name;
												}
												?>
											<tr>
												<td><?= $i; ?></td>
												<td><?= $bankName;?></td>
												<td><?= $customerrow->loan_name;?></td>
												<td><?= $customerrow->interest_rate;?></td>
											</tr>
											<?php $i++; } }else{ ?>
												<tr>
                                                	<td colspan="4">Data not found</td>
                                            	</tr>
											<?php } ?>
										</tbody>
									</table>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php } ?>
						<div class="row">
                        <!-- Pie Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Loan Request List</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table table-striped" id="exampleId1">
                                        <thead>
                                            <th>Sr No</th>
                                            <th>Bank Name</th>
                                            <th>Loan Type</th>
                                            <th>Loan Request Number</th>
                                            <th>Total Loan Amount (Rs)</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($getRequest)) { 
												$sr=1; 
												foreach($getRequest as $data){
													$getBankData = $this->Dashboard_model->GetData('mst_banks','name','is_delete="No" and status="Active" and id="'.$data->bank_id.'"','','','','1'); 
													$BANK_NAME= 'N/A';
													if(!empty($getBankData->name)){
														$BANK_NAME=$getBankData->name;
													}
													$getLoanType = $this->Dashboard_model->GetData('mst_loans','loan_name','is_delete="No" and status="Active" and id="'.$data->bank_id.'"','','','','1'); 
													$LOAN_TYPE= 'N/A';
													if(!empty($getLoanType->loan_name)){
														$LOAN_TYPE=$getLoanType->loan_name;
													}

												?>
											<tr>
                                            <td><?= $sr; ?></td>
                                            <td><?= $BANK_NAME; ?></td>
                                            <td><?= $LOAN_TYPE; ?></td>
                                            <td><a
                                                    href="<?= site_url('Dashboard/viewLoanRequest/'.$data->edit_id) ?>"><?= !empty($data->request_number) ? $data->request_number:"N/A"; ?></a>
                                            </td>
                                            <td><?= !empty($data->total_payable) ? $data->total_payable:"N/A"; ?></td>
                                            <td><?= !empty($data->created) ? $data->created:"N/A"; ?></td>
                                            <td>
                                                <?php if($data->status=='Approved') { ?>
                                                <span class="bagde badge-success p-2"><?= $data->status; ?></span>
                                                <?php }else if($data->status=='Rejected') {?>
                                                <span class="bagde badge-danger p-2"><?= $data->status; ?></span>
                                                <?php }else{ ?>
                                                <span class="bagde badge-warning p-2"><?= $data->status; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'Employee' || $_SESSION['user_type'] == 'Customer')): ?>
                                                <?php if(isset($data->status) && $_SESSION['user_type'] == 'Customer' && $data->status != 'Pending'): ?>
                                                N/A
                                                <?php else: ?>
                                                <a
                                                    onclick="deleteData('<?= isset($data->edit_id) ? $data->edit_id : ''; ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <?php endif; ?>

                                                <?php if($_SESSION['user_type'] == 'Employee' && isset($data->status) && $data->status != 'Approved'): ?>
                                                | <a href="#"
                                                    onclick="openStatusModal('<?= isset($data->edit_id) ? $data->edit_id : ''; ?>')">
                                                    <i class="fa fa-info"></i>
                                                </a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            </tr>
                                            <?php $sr++; } }else{ ?>
                                            <tr>
                                                <td colspan="8">Data not found</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Customer' && count($checkRequestApproved) > 0) {  ?>
                    <div class="row">
                        <!-- Pie Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Calendar</h6>
                                </div>
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
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
    <div class="modal  fade" id="requestForLoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request For Loan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" action="<?= site_url('Dashboard/saveLoanRequest') ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bank_id">Bank <span class="required">* <span
                                            id="bank_id_error"></span></span></label>
                                <select name="bank_id" class="form-control" id="bank_id"
                                    onchange="getLoanType(this.value)">
                                    <option value="">Select Bank</option>
                                    <?php foreach ($GetBank as $Bankrow) {  ?>
                                    <option value="<?= $Bankrow->id; ?>"
                                        <?= !empty($id) && ($id == $Bankrow->id) ? 'selected' : ''; ?>>
                                        <?= $Bankrow->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="loan_type">Loan Type <span class="required">* <span
                                            id="loan_type_error"></span></span></label>
                                <select class="form-control" id="loan_type" name="loan_type"
                                    onchange="getInterest(this.value)">
                                    <option value="">Select Loan Type </option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="loan_type_detail" style="display:none;">
                            <div class="form-group col-md-6">
                                <label for="Loan_amount">Loan Amount <span class="required">* <span
                                            id="loan_amount_error"></span></span></label>
                                <input type="text" class="form-control" id="loan_amount" name="loan_amount"
                                    placeholder="Enter Loan Amount" maxlenght="5" onkeyup="calEmi()">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="interest_rate">Interest Rate(%) <span class="required">* <span
                                            id="interest_rate_error"></span></span></label>
                                <input type="text" class="form-control" id="interest_rate" name="interest_rate"
                                    placeholder="Enter Interest Rate" readonly maxlenght="2">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tennure">Tennure (In Months) <span class="required">* <span
                                            id="tennure_error"></span></span></label>
                                <input type="text" class="form-control" id="tennure" name="tennure"
                                    placeholder="Enter Tennure" maxlenght="2" onkeyup="calEmi()">
                            </div>
                            <div class="col-md-12" style="text-align:center">
                                <div>
                                    <h2><b>Per Month EMI Amount</b></h2>
                                    <h3 id="loan_emi"></h3>
                                    <input type="hidden" name="loan_emi_value" id="loan_emi_value" />
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Interest</b></h2>
                                    <h3 id="total_interest_rate"></h3>
                                    <input type="hidden" name="total_interest_rate_value"
                                        id="total_interest_rate_value" />
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Processing Fee</b></h2>
                                    <h3 id="processing_fee"></h3>
                                    <input type="hidden" name="processing_fee_value" id="processing_fee_value" />
                                </div>
                                <hr>
                                <div>
                                    <h2><b>Total Payment</b></h2>
                                    <h3 id="total_payment"></h3>
                                    <input type="hidden" name="total_payment" id="total_payment_value" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit" onclick="return valid()">Submit</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal  fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form method="POST" action="<?= site_url('Dashboard/changeStatusLoanRequest') ?>">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Status Of Loan Request</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
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
    <!-- Custom scripts for all pages-->
    <script src=<?= base_url()."assets/js/sb-admin-2.min.js"?>></script>
    <!-- Page level plugins -->
    <script src=<?= base_url()."assets/vendor/chart.js/Chart.min.js"?>></script>
    <!-- Page level custom scripts -->
    <script src=<?= base_url()."assets/js/demo/chart-area-demo.js" ?>></script>
    <script src=<?= base_url()."assets/js/demo/chart-pie-demo.js" ?>></script>
    <script src=<?= base_url()."assets/js/demo/chart-bar-demo.js" ?>></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
		$(document).ready( function () {
    $('#exampleId').DataTable();
  });
  $(document).ready( function () {
    $('#exampleId1').DataTable();
  });
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var objArray = JSON.parse('<?= $emiDateCalendarArray; ?>');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: objArray,
            eventContent: function(info) {
                // Add HTML to the title or any other part of the event
                let backgroundColor = '';
                if (info.event.extendedProps.status == 'Yes') {
                    backgroundColor = 'green';
                } else if (info.event.extendedProps.status == 'No') {
                    backgroundColor = 'orange';
                }
                return {
                    html: '<div class="fc-title" style=background-color:' + backgroundColor + '>' +
                        info.event.title + '</div>'
                };
            },

        });
        calendar.render();
    });
    </script>

    </script>

    <script>
    function getLoanType(bank_id) {
        // alert(countryId);
        var site_url = '<?= site_url(); ?>';
        var url = site_url + "/Dashboard/getLoanType";
        var dataString = "bank_id=" + bank_id;
        //alert(dataString); 
        $.post(url, dataString, function(returndata) {
            var obj = $.parseJSON(returndata);
            $('#loan_type').html(obj.html);
            $('#interest_rate').val('');
            $('#tennure').val('');
        });
    }

    function getInterest(loan_type) {
        var site_url = '<?= site_url(); ?>';
        var url = site_url + "/Dashboard/getInterest";
        var dataString = "loan_type=" + loan_type;
        $.post(url, dataString, function(returndata) {
            var obj = $.parseJSON(returndata);
            if (obj.success == '1') {
                $('#loan_type_detail').show();
            } else {
                $('#loan_type_detail').hide();
            }
            $('#interest_rate').val(obj.html);
        });
    }

    // function calEmi() {
    //     var loan_amount = $('#loan_amount').val();
    //     var tennure = $('#tennure').val();
    //     var interest_rate = $('#interest_rate').val();

    //     console.log(parseFloat(interest_rate) / parseFloat(tennure), 'Interest');
    //     var interest_rate_new = (((parseFloat(interest_rate) / parseFloat(tennure))) / 100 * parseFloat(loan_amount));
    //     console.log(interest_rate_new, 'rate');
    //     var test = ((parseFloat(interest_rate) / parseFloat(tennure))) / 100;
    //     var emi = (parseFloat(loan_amount) * parseFloat(test) * (1 + parseFloat(test)) ^
    //         parseFloat(
    //             tennure)) / (((1 + parseFloat(test)) ^ parseFloat(tennure) - 1));
    //     console.log(emi);
    // }

    function calEmi() {
        var loan_amount = parseFloat($('#loan_amount').val());
        var tenure = parseInt($('#tennure').val()); // In months
        var interest_rate = parseFloat($('#interest_rate').val());

        // Calculate the monthly interest rate
        var annual_rate_intrest = interest_rate / (100 * 12);
        // EMI calculation formula
        var emi = (loan_amount * annual_rate_intrest * Math.pow((1 + parseFloat(annual_rate_intrest)), tenure)) / (Math
            .pow((1 + parseFloat(annual_rate_intrest)), tenure) - 1);
        var montly_interest_amount = emi * tenure - loan_amount;
        var total_payment = parseFloat(Math.round(montly_interest_amount)) + parseFloat(Math.round(loan_amount)) + 400;

        // Show results
        console.log(Math.round(emi), 'EMI');
        console.log(Math.round(montly_interest_amount), 'Montly In Amount');
        console.log(Math.round(total_payment), 'Total Payment');
        console.log(Math.round(10), 'Processing Fee');

        $('#loan_emi').text('Rs. ' + Math.round(emi));
        $('#total_interest_rate').text('Rs. ' + Math.round(montly_interest_amount));
        $('#total_payment').text('Rs. ' + Math.round(total_payment));
        $('#processing_fee').text('Rs. ' + 400);
        $('#loan_emi_value').val(Math.round(emi));
        $('#total_interest_rate_value').val(Math.round(montly_interest_amount));
        $('#total_payment_value').val(Math.round(total_payment));
        $('#processing_fee_value').val(400);
    }

    function valid() {
        var bank = $('#bank_id').val();
        var loan_type = $('#loan_type').val();
        var loan_amount = $('#loan_amount').val();
        var tenure = $('#tennure').val();
        var interest_rate = $('#interest_rate').val();
        let pattern = /^[0-9]+$/;
        if (bank == '') {
            $('#bank_id_error').text('Required');
            setTimeout(() => {
                $('#bank_id_error').text('');
            }, 2000);
            $('#bank_id').focus();
            return false;
        } else if (loan_type == '') {
            $('#loan_type_error').text('Required');
            setTimeout(() => {
                $('#loan_type_error').text('');
            }, 2000);
            $('#loan_type').focus();
            return false;

        } else if (loan_amount == '') {
            $('#loan_amount_error').text('Required');
            setTimeout(() => {
                $('#loan_amount_error').text('');
            }, 2000);
            $('#loan_amount').focus();
            return false;
        } else if (!pattern.test(loan_amount)) {
            $('#loan_amount_error').text('Please enter valid amount');
            setTimeout(() => {
                $('#loan_amount_error').text('');
            }, 2000);
            $('#loan_amount').focus();
            return false;
        } else if (interest_rate == '') {
            $('#interest_rate_error').text('Required');
            setTimeout(() => {
                $('#interest_rate_error').text('');
            }, 2000);
            $('#interest_rate').focus();
            return false;
        } else if (tenure == '') {
            $('#tennure_error').text('Required');
            setTimeout(() => {
                $('#tennure_error').text('');
            }, 2000);
            $('#tennure').focus();
            return false;
        } else if (!pattern.test(tenure)) {
            $('#tennure_error').text('Please enter valid tennure');
            setTimeout(() => {
                $('#tennure_error').text('');
            }, 2000);
            return false;
        } else {
            return true;
        }
    }

    function openStatusModal(id) {
        $('#req_id').val(id);
        $('#statusModal').modal('show');

    }

    function deleteData(id) {
        if (confirm('Are you sure to delete ?')) {
            window.location = '<?= site_url('Dashboard/deleteLoanRequest/') ?>' + id;
        }
    }
    </script>
</body>
