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
				<form method="post" action="<?= $action; ?>">
					<div class="profileform">
						<div class="heading-panel text-center">
							<h3 class="main-title">Create Profile</h3>
						</div>

						<!-- Name -->
						<div class="form-group">
							<label class="control-label">
								<font color="#FF3300">*</font> Name
							</label>
							<input class="form-control" name="name" placeholder="Enter Name"
								type="text" value="<?= set_value('name', $name); ?>" required>
						</div>
						<!-- Email -->
						<div class="form-group">
							<label class="control-label">
								<font color="#FF3300">*</font> Email
							</label>
							<input class="form-control" placeholder="Enter Email"
								name="email_address" type="email"
								value="<?= set_value('email_address', $email_address); ?>"
								required>
						</div>

						<!-- Mobile Number -->
						<div class="form-group">
							<label class="control-label">
								<font color="#FF3300">*</font> Mobile Number
							</label>
							<input class="form-control" name="mobnum" type="text" maxlength="10"
								placeholder="Ex 8888888885"
								onkeypress='return event.charCode >= 48 && event.charCode <= 57'
								value="<?= set_value('mobnum', $mobnum); ?>" required>
						</div>

						<!-- Gender -->
						<div class="form-group">
							<label class="control-label">
								<font color="#FF3300">*</font> Gender
							</label>
							<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
								<input type="radio" name="gender" value="Female"
									<?= ($gender == 'Female' || set_value('gender') == 'Female') ? 'checked' : ''; ?>>
								Female
							</div>
							<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
								<input type="radio" name="gender" value="Male"
									<?= ($gender == 'Male' || set_value('gender') == 'Male') ? 'checked' : ''; ?>>
								Male
							</div>
							<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
								<input type="radio" name="gender" value="Other"
									<?= ($gender == 'Other' || set_value('gender') == 'Other') ? 'checked' : ''; ?>>
								Other
							</div>
						</div>

						<!-- Education -->
						<div class="form-group">
							<label class="control-label">
								<font color="#FF3300">*</font> Education
							</label>
							<select class="form-control" name="educ" required>
								<option selected="selected" disabled="disabled">Choose...
								</option>
								<option value="SSC"
									<?= ($educ == 'SSC' || set_value('educ') == 'SSC') ? 'selected' : ''; ?>>
									SSC</option>
								<option value="HSC"
									<?= ($educ == 'HSC' || set_value('educ') == 'HSC') ? 'selected' : ''; ?>>
									HSC</option>
								<option value="Diploma"
									<?= ($educ == 'Diploma' || set_value('educ') == 'Diploma') ? 'selected' : ''; ?>>
									Diploma</option>
								<option value="BE"
									<?= ($educ == 'BE' || set_value('educ') == 'BE') ? 'selected' : ''; ?>>
									BE</option>
								<option value="MBA/MCA"
									<?= ($educ == 'MBA/MCA' || set_value('educ') == 'MBA/MCA') ? 'selected' : ''; ?>>
									MBA/MCA</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">
								Profile Pic
							</label>
							<input class="form-control" name="profile_pic" 
								type="file"  accept="image/png, image/jpeg"/>
						</div>
						<div class="form-group">
							<button type="submit" name="create"
								class="btn btn-success btn-sm"><?= $button; ?></button>
							<button type="button" name="cancel" class="btn btn-danger btn-sm"
								onclick="window.location='<?= $cancel_action; ?>'"><?= $cancel; ?></button>
						</div>
					</div>
				</form>
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
