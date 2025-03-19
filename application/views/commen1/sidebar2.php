<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?php echo site_url('Dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Loan Bridge</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']=='Employee') { ?>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Banks'); ?>">
            <i class="fas fa-fw fas fa-landmark"></i>
            <span>Banks</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Loans'); ?>">
            <i class="fas fa-fw fas  fa-money-bill"></i>
            <span>Loans</span></a>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Notices'); ?>">
            <i class="fas fa-fw fas  fa-money-bill"></i>
            <span>Notices</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <?php } ?>
</ul>