<style>
input[type="file"] {
    display: block;
}

.imageThumb {
    max-height: 75px;
    border: 2px solid;
    padding: 1px;
    cursor: pointer;
}

.pip {
    display: inline-block;
    margin: 10px 10px 0 0;
}

.remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
}

.remove:hover {
    background: white;
    color: black;
}
</style>
<?php $this->load->view('commen1/header2'); ?>
<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI library (Include the JavaScript for jQuery UI autocomplete) -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<style>
/* Custom styling for autocomplete dropdown */
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
}

/* IE 6 doesn't support max-height
         * we use height instead, but this forces the menu to always be this tall
         */
* html .ui-autocomplete {
    height: 200px;
}

.ui-menu-item {
    padding: 5px 10px;
}

.ui-menu-item:hover {
    background-color: #ddd;
    cursor: pointer;
}
</style>

<body>
    <div class="container-fluid">
        <div class="row" id="menu-row">
            <!-- first row start-->
            <?php $this->load->view('commen1/navbar2'); ?>
        </div><!-- first row end-->
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
                                <h1 class="card-title">Add Details</h1>

                                <form method="post" action="<?= $action;?>">
                                    <input type="hidden" id="city_id" name="user_id">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Name</label><span class="text text-danger"> *
                                            <?= form_error('name') ?></span>
                                        <input type="text" class="form-control" name="name" id="exampleInputName1"
                                            placeholder="Name" value="<?= !empty($name) ? $name : ''; ?>"
                                            autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Email address</label><span
                                            class="text text-danger"> * <?= form_error('email_address'); ?> </span>
                                        <input type="email" class="form-control" name="email_address"
                                            id="exampleInputEmail3" placeholder="Email"
                                            value="<?= !empty($email_address) ? $email_address : ''; ?>"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label><span class="text text-danger"> *
                                            <?= form_error('address') ?></span>
                                        <div>
                                            <textarea class="form-control" name="address" id="exampleInputEmail4"
                                                rows="3"
                                                autocomplete="off"><?= !empty($address) ? $address : ''; ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth</label><span
                                            class="text text-danger"> * <?= form_error('dob') ?></span>
                                        <div>
                                            <input type="date" name="dob" class="form-control"
                                                value="<?= !empty($dob) ? $dob : ''; ?>"
                                                placeholder="Select Your Date" />
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label>Gender</label><span class="text text-danger"> *
                                            <?= form_error('gender') ?></span>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="Male"
                                                <?= !empty($gender) && ($gender == "Male") ? 'checked' : ''; ?>> Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="Female"
                                                <?= !empty($gender) && ($gender == "Female") ? 'checked' : ''; ?>>
                                            Female
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="Other"
                                                <?= !empty($gender) && ($gender == "Other") ? 'checked' : ''; ?>> Other
                                        </label>
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

                                    <button type="submit" name="create"
                                        class="btn btn-success btn-sm"><?= $button; ?></button>
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
    <input type="hidden" name="site_url" id="site_url" value="<?php echo site_url(); ?>">
    <input type="hidden" id="file_count">
    </div>
    <div class="row">
        <?php $this->load->view('commen1/footer2') ?>
    </div>

</body>

</html>