<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!$this->session->schoolmis_login_level) {
    redirect(base_url('login'));
}
$uri = $this->session->schoolmis_login_uri;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <div class="container">
        <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="#" class="navbar-brand">
            <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span> -->
            <img src="<?= $system_svg ?>" alt="Locator Logo" class="brand-image">
            <span class="brand-text"><b>ANHSIS</b></span>
        </a>

        <div class="collapse navbar-collapse order-1" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <!-- <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form> -->
            <!-- <div class="form-inline ml-0 ml-md-3">
        <div class="input-group input-group-sm float-right">
          <div class="input-group-prepend">
            <button class="btn btn-navbar" type="submit">
              S.Y.
            </button>
          </div>
          <input class="form-control form-control-navbar" value="<?= $getOnLoad["sy"]; ?>" disabled>
        </div>
      </div> -->
        </div>

        <!-- Right navbar links -->
        <ul class="order-3 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <!-- <a class="nav-link" data-toggle="dropdown" href="#"> -->
                <?= $getOnLoad["sy_qrtr_e_g"]; ?>
                <!-- </a> -->
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="<?= $system_svg ?>" alt="Locator Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>ANHSIS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fa fa-user fa-3x text-lightblue mt-2"></i>
                <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info mb-0">
                <a href="#" class="d-block"><?= $this->session->schoolmis_login_name ?><br />
                    <small><?= $this->session->schoolmis_login_title ?><br /><?= $this->session->schoolmis_login_uname ?></small>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <!-- <li class="nav-item">
                <a href="<?= base_url() . $uri ?>/dashboard" class="nav-link dashboard">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard
                    </p>
                </a>
                </li> -->
                <li class="nav-item">
                    <a href="<?= base_url() . $uri ?>/dataentry" class="nav-link dataentry">
                        <i class="nav-icon fas fa-edit data_entry"></i>
                        <p>
                            Data Entry
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                <a href="<?= base_url() . $uri ?>/datacontroller" class="nav-link datacontroller">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                    Controller
                    </p>
                </a>
                </li> -->
                <li class="nav-item">
                    <a href="<?= base_url() . $uri ?>/report" class="nav-link report">
                        <i class="nav-icon fas fa-file report"></i>
                        <p>
                            Reports
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Sign Out
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>