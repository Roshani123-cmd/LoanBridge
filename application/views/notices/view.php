<?php $this->load->view('commen1/header2'); ?>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <?php $this->load->view('commen1/navbar2'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_sidebar.html -->

            <div class="content-wrapper">

                <div class="row">
                    <!-- second row start -->
                    <div class="col-md-2 col-sm-2 col-xs-12 example-navbar-collapse content height">
                        <!-- Left Panel start -->
                        <?php $this->load->view('commen1/sidebar2'); ?>
                    </div> <!-- Left Panel End -->
                    <div class="col-md-10 col-sm-10 col-xs-12 col-lg-10 height">
                        <!-- Right Panel start -->
                        <div>
                            <h2><?= $screen; ?></h2>
                            <hr />
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?= $records; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <?php foreach ($CustomersData as $customers) { ?>
                                                <tr>
                                                    <td><strong>User</strong></td>
                                                    <td><?= $customers->name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Name</strong></td>
                                                    <td><?= $customers->name; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email Address</strong></td>
                                                    <td><?= $customers->email_address; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Address</strong></td>
                                                    <td><?= $customers->address; ?></td>
                                                </tr>
                                                <!-- Uncomment these lines if you want to show About Guest and Hobby details -->

                                                <tr>
                                                    <td><strong>Date Of Birth</strong></td>
                                                    <td><?= $customers->dob; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gender</strong></td>
                                                    <td><?= $customers->gender; ?></td>
                                                </tr>
                                                <!-- <tr>
                                                <td><strong>Country</strong></td>
                                                <td><?= $allguest->country_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>State</strong></td>
                                                <td><?= $allguest->state_name; ?></td>
                                            </tr> -->
                                                <!-- <tr>
                                                <td><strong>City</strong></td>
                                                <td><?= $allguest->city_name; ?></td>
                                            </tr> -->
                                                <!-- <tr>
                                               
                                            </tr> -->
                                                <!-- <tr>
                                                <td><strong>Photo</strong></td>
                                                <td><img src="<?= base_url('/uploads/guests_photo/' . $allguest->photo); ?>" alt="photo" width="50px" /></td>
                                            </tr> -->

                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td><?= $customers->status; ?></td>
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
                    </div> <!-- Right Panel End -->
                </div> <!-- second row end -->

                <!-- Import Section -->

                <!-- End of Import Section -->

            </div>
        </div>
        <?php $this->load->view('commen1/footer2') ?>
    </div>

</body>

</html>