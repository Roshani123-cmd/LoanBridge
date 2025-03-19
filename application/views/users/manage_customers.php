<?php $this->load->view('commen1/header2'); ?>

<body>
    <div class="container-fluid">
        <?php $this->load->view('commen1/navbar2'); ?>
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_sidebar.html -->

            <div class="content-wrapper">


                <div class="row">
                    <!-- second row start-->
                    <div class="col-md-2 col-sm-2 col-xs-12 example-navbar-collapse content new-height">
                        <?php $this->load->view('commen1/sidebar2'); ?>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12 col-lg-10 new-height">
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="page-title">Manage Customers</h1>
                                        <div style="text-align: right;">
                                            <button type="button" class="btn btn-primary"
                                                onclick="window.location='<?= $button_action ?>'">
                                                <?= $button; ?>
                                            </button>
                                        </div>
                                        <br>
                                        <br>

                                        <form method="post" action="<?= site_url('Welcome/deleteall_action'); ?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkall"
                                                                onclick="getAllCheck()" /></th>
                                                        <th>SR No.</th>
                                                        <th>Name</th>
                                                        <th>Email Address</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; foreach ($GetCustomers as $customerrow) { ?>
                                                    <tr>
                                                        <td><input type="checkbox" class="selector" name="selector[]"
                                                                value="<?= $customerrow->token; ?>" /></td>
                                                        <input type="hidden" id="get_id_<?= $i ?>" value="" />
                                                        <td><?= $i; ?></td>
                                                        <td><?= $customerrow->name; ?></td>
                                                        <td><?= $customerrow->email_address; ?></td>
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
                                                        <td><?= $this->Users_model->time_ago($customerrow->created); ?>
                                                        </td>
                                                        <td>

                                                            <a href="<?= site_url('Welcome/view_action/' . ($customerrow->id)); ?>"
                                                                class="mdi mdi-eye btn btn-primary btn-sm"><span
                                                                    class="fa fa-eye"></a>
                                                            <a href="<?= site_url('Welcome/update/' .($customerrow->id)); ?>"
                                                                class="mdi mdi-pencil btn btn-warning btn-sm"><span
                                                                    class="fa fa-edit"></span></a>
                                                            <a href="<?= site_url('Welcome/delete_action/' .$customerrow->id); ?>"
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

                <!-- Import Section -->

                <!-- End of Import Section -->

            </div>
        </div>

        <?php $this->load->view('commen1/footer2') ?>
    </div>
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
</body>

</html>