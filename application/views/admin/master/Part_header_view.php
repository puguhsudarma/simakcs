<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url(); ?>" class="logo">
        <span class="logo-lg"><b><?php echo $header; ?></b></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>Hi, <?php echo $nama_admin; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="<?php echo base_url('assets/images/avatar5.png'); ?>" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo $nama_admin; ?>
                                <small>Administrator</small>
                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                                <a href="<?php echo site_url('Autentikasi/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>