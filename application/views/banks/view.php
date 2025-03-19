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
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <?php foreach ($CustomersData as $customers) { ?>
                                                <tr>
                                                    <td><strong>User</strong></td>
                                                    <td><?= $customers->name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>IFSC Code</strong></td>
                                                    <td><?= $customers->ifsc_code; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>
                                                        <?php if ($customers->status == "Active") { ?>
                                                        <span
                                                            class="badge badge-success"><?= $customers->status; ?></span>
                                                        <?php } elseif ($customers->status == "Block") { ?>
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