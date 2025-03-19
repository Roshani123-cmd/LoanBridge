<?php $this->load->view('commen1/header2')?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
											<h1 class="card-title"><?= $page_title; ?></h1>

											<form method="post" action="<?= $action;?>">
												<input type="hidden" id="city_id" name="user_id">
												<div class="form-group">
													<label for="exampleInputName1">Title</label><span class="text text-danger"> *
														<?= form_error('name') ?></span>
													<input type="text" class="form-control" name="name" id="exampleInputName1"
														placeholder="Title" value="<?= !empty($name) ? $name : ''; ?>"
														autocomplete="off">
												</div>
												<div class="form-group">
													<label for="exampleInputName1">Decription</label><span class="text text-danger">
														*
														<?= form_error('description') ?></span>
													<textarea class="form-control" name="description"
														placeholder="Description"><?= !empty($description) ? $description : ''; ?></textarea>
												</div>
												<div class="form-group">
													<label for="user_id">Select Users</label><span class="text text-danger">
														*</span>
													<select multiple class="form-control select2" name="user_ids[]" data-placeholder="Select User">
														<option value="All Users">All Users</option>
														<!-- Add an option to select all users -->
														<?php foreach ($all_users as $user): ?>
														<option value="<?= $user->id ?>"
															<?= (isset($selected_users) && in_array($user->id, $selected_users)) ? 'selected' : ''; ?>>
															<?= $user->name ?>
														</option>
														<?php endforeach; ?>
													</select>
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


												<button type="submit" name="create" class="btn btn-success btn-sm">
													<?= $button; ?>
												</button>

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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script>
$(document).ready(function () {
  $(".select2").select2();
});
	</script>
</body>
