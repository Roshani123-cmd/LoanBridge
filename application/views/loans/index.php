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
                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-primary"
                                            onclick="window.location='<?= $button_action ?>'">
                                            <?= $button; ?>
                                        </button>
                                    </div>
                                    <br>
                                    <br>

                                    <form method="post" action="<?= site_url('Loans/deleteall_action'); ?>">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkall" onclick="getAllCheck()" />
                                                    </th>
                                                    <th>SR No.</th>
                                                    <th>Bank Name</th>
                                                    <th>Loan Name</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach ($allLoanType as $customerrow) {
                                                    $bankName = 'Not Available';
                                                    $getBank = $this->Loan_model->GetData('mst_banks','','status="Active" and id="'.$customerrow->bank_id.'"','id DESC','','','1'); 
                                                    if(!empty($getBank)){
                                                        $bankName = $getBank->name;
                                                    }
                                                    ?>
                                                <tr>
                                                    <td><input type="checkbox" class="selector" name="selector[]"
                                                            value="<?= $customerrow->edit_id; ?>"
                                                            id="get_id_<?= $i ?>" /></td>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $bankName;?></td>
                                                    <td><?= $customerrow->loan_name;?></td>
                                                    <td>
                                                        <?php if ($customerrow->status == "Active") { ?>
                                                        <span
                                                            class="badge badge-success"><?= $customerrow->status; ?></span>
                                                        <?php } elseif ($customerrow->status == "Inactive") { ?>
                                                        <span
                                                            class="badge badge-danger"><?= $customerrow->status; ?></span>
                                                        <?php } else { ?>
                                                        <span
                                                            class="badge badge-warning"><?= $customerrow->status; ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $this->Loan_model->time_ago($customerrow->created); ?>
                                                    </td>
                                                    <td>

                                                        <a href="<?= site_url('Loans/view_action/' . ($customerrow->edit_id)); ?>"
                                                            class="mdi mdi-eye btn btn-primary btn-sm"><span
                                                                class="fa fa-eye"></a>
                                                        <a href="<?= site_url('Loans/update/' .($customerrow->edit_id)); ?>"
                                                            class="mdi mdi-pencil btn btn-warning btn-sm"><span
                                                                class="fa fa-edit"></span></a>
                                                        <a href="<?= site_url('Loans/delete_action/' .$customerrow->edit_id); ?>"
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
                                                        <button type="submit" name="deleteall" class="btn btn-danger"
                                                            onclick="return confirm('Do you really want to delete records?');"
                                                            value="deleteAll" style="display:none;" id="deleteAll">All
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
                    <!-- Import Section -->

                    <!-- End of Import Section -->
                </div>
            </div>
            <?php $this->load->view('commen1/footer2') ?>
        </div>
        <!-- Begin Page Content -->


    </div>
    <script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#datatablelist').DataTable();

        // Handle "select all" checkbox
        // $('#checkall').click(function() {
        //     var isChecked = this.checked; // Get the checked state of the "select all" checkbox
        //     $('.selector').prop('checked', isChecked); // Set the state for all checkboxes
        // });

        // // Handle individual checkbox changes
        // $('#datatablelist tbody').on('change', '.selector', function() {
        //     var allChecked = $('#datatablelist tbody .selector:checked').length === $(
        //         '#datatablelist tbody .selector').length;
        //     $('#checkall').prop('checked', allChecked); // Update the "select all" checkbox
        // });
    });
    $('.selector').click(function() {
        var checked = false;
        $('.selector').each(function() {
            checked = this.checked;
        });
        if (checked) {
            $('#deleteAll').show();
        } else {
            $('#deleteAll').hide();
        }
    });

    function getAllCheck() {

        var mainCheck = $('#checkall').is(':checked');
        if (mainCheck == true) {
            $('.selector').prop('checked', true);
            $('#deleteAll').show();
        } else {
            $('.selector').prop('checked', false);
            $('#deleteAll').hide();
        }
    }
    </script>
</body>

</html>