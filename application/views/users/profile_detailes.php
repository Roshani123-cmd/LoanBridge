<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/bootstrap.min.css">
    <link rel="stylesheet" src="<?php echo base_url(); ?>template/css/style.css">
    <script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>template/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <!-- <h2>Profile Details
            <a href="<?php echo base_url();?>" class="btn btn-success pull-right">Back</a>
        </h2> -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Profile Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Gender</th>
                        <th>Education</th>
                        <th>Hobbies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $cnt = 0; foreach ($user_profile as $row):  $cnt+=1; ?>
                    <tr>
                        <td><?php echo $cnt;?></td>
                        <td><img src="<?php echo base_url();?>template/images/profile_<?php echo $row->id.'.jpg';?>"
                                width="100px" height="70px"></td>
                        <td><?php echo $row->name;?></td>
                        <td><?php echo $row->email;?></td>
                        <td><?php echo $row->mobnum;?></td>
                        <td><?php echo $row->gender;?></td>
                        <td><?php echo $row->educ;?></td>
                        <td><?php echo $row->hobbies;?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>