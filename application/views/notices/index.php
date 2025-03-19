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
			<div id="content">
                <?php $this->load->view('commen1/navbar2')?>
                <div class="container-fluid">
					<div class="row">
						<div class="col-md-10 col-sm-10 col-xs-12 col-lg-10 new-height">
							<div class="row">
								<div class="col-12 grid-margin stretch-card">
									<div class="card">
										<div class="card-body">
											<h1 class="page-title">Manage Notices</h1>
											<div style="text-align: right;">
												<button type="button" class="btn btn-primary"
													onclick="window.location='<?= $button_action ?>'">
													<?= $button; ?>
												</button>
											</div>
											<br>
											<br>

											<form method="post" action="<?= site_url('Notices/deleteall_action'); ?>">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th><input type="checkbox" id="checkall"
																	onclick="getAllCheck()" /></th>
															<th>SR No.</th>
															<th>Title</th>
															<th>Status</th>
															<th>Created</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 1; foreach ($GetNotices as $customerrow) { ?>
														<tr>
															<td><input type="checkbox" class="selector" name="selector[]"
																	value="" /></td>
															<input type="hidden" id="get_id_<?= $i ?>" value="" />
															<td><?= $i; ?></td>
															<td><?= $customerrow->title;?></td>
															<td>
																<?php if ($customerrow->status == "Active") { ?>
																<span
																	class="badge badge-success"><?= $customerrow->status; ?></span>
																<?php } elseif ($customerrow->status == "Block") { ?>
																<span
																	class="badge badge-danger"><?= $customerrow->status; ?></span>
																<?php } else { ?>
																<span
																	class="badge badge-warning"><?= $customerrow->status; ?></span>
																<?php } ?>
															</td>
															<td><?= $this->Notice_model->time_ago($customerrow->created); ?>
															</td>
															<td>

																<!-- <a href="<?= site_url('Notices/view_action/' . ($customerrow->id)); ?>"
																	class="mdi mdi-eye btn btn-primary btn-sm"><span
																		class="fa fa-eye"></a> -->
																<!-- <a href="<?= site_url('Notices/update/' .($customerrow->id)); ?>"
																	class="mdi mdi-pencil btn btn-warning btn-sm"><span
																		class="fa fa-edit"></span></a> -->
																<a href="<?= site_url('Notices/delete_action/' .$customerrow->id); ?>"
																	class="mdi mdi-delete btn btn-danger btn-sm"
																	onclick="return confirm('Do you really want to delete this record')"><span
																		class="fa fa-trash"></a>
															</td>
														</tr>
														<?php $i++; } ?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="10">
																<button type="submit" name="deleteall"
																	class="btn btn-danger"
																	onclick="return confirm('Do you really want to delete records?');">All
																	Delete</button>
															</td>
														</tr>
													</tfoot>
												</table>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $this->load->view('commen1/footer2')?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#datatablelist').DataTable();

        // Handle "select all" checkbox
        $('#checkall').click(function() {
            var isChecked = this.checked; // Get the checked state of the "select all" checkbox
            $('.selector').prop('checked', isChecked); // Set the state for all checkboxes
        });

        // Handle individual checkbox changes
        $('#datatablelist tbody').on('change', '.selector', function() {
            var allChecked = $('#datatablelist tbody .selector:checked').length === $(
                '#datatablelist tbody .selector').length;
            $('#checkall').prop('checked', allChecked); // Update the "select all" checkbox
        });
    });

    function getAllCheck() {

        var mainCheck = $('#checkall').is(':checked');
        if (mainCheck == true) {
            $('.selector').prop('checked', true);
        } else {
            $('.selector').prop('checked', false);
        }
    }
    </script>
