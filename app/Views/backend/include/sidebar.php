<div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li  class="nav-item" >
                               <a class="nav-link <?php echo (uri_string() === '') ? 'active' : ''; ?>" href="<?php echo site_url('/') ?>" aria-expanded="false"><i class="fa-xs fas fa-tachometer-alt"></i>Dashboard <span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'user') ? 'active' : ''; ?>" href="<?php echo site_url('/user') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-user-circle"></i>Users <span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (uri_string() === 'customer_classification') ? 'active' : ''; ?>" href="<?php echo site_url('/customer_classification') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-building"></i>Customer Classifications<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (uri_string() === 'task_status') ? 'active' : ''; ?>" href="<?php echo site_url('/task_status') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-building"></i>Task Status <span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (uri_string() === 'visit_status') ? 'active' : ''; ?>" href="<?php echo site_url('/visit_status') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-building"></i>Visit Status <span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'city') ? 'active' : ''; ?>" href="<?php echo site_url('/city') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-building"></i>City <span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fa-xs fa fa-fw fa-home"></i>Property</a>
                                <div id="submenu-3" class="collapse submenu <?php echo (uri_string() === 'property' || uri_string() === 'property/sale-property' || uri_string() === 'property/rent-property' || uri_string() === 'property/construction-property') ? 'show' : ''; ?>" style="">
                                    <ul class="nav flex-column" style="padding-left: 27px !important">
                                    <li class="nav-item">
                                    <a class="nav-link <?php echo (uri_string() === 'property') ? 'active' : ''; ?>" href="<?php echo site_url('/property') ?>" aria-expanded="false">Property<span class="badge badge-success">6</span></a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link <?php echo (uri_string() === 'property/sale-property') ? 'active' : ''; ?>" href="<?php echo site_url('/property/sale-property') ?>" aria-expanded="false">Sale Property<span class="badge badge-success">6</span></a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link <?php echo (uri_string() === 'property/rent-property') ? 'active' : ''; ?>" href="<?php echo site_url('/property/rent-property') ?>" aria-expanded="false">Rent Property<span class="badge badge-success">6</span></a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link <?php echo (uri_string() === 'property/construction-property') ? 'active' : ''; ?>" href="<?php echo site_url('/property/construction-property') ?>" aria-expanded="false">Pre-Construction<span class="badge badge-success">6</span></a>
                                    </li>
                                    </ul>
                                </div>
                            </li>
                           
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'slider') ? 'active' : ''; ?>" href="<?php echo site_url('/slider') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-image"></i>Slider Image<span class="badge badge-success">6</span></a>
                            </li>
                           
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'brand') ? 'active' : ''; ?>" href="<?php echo site_url('/brand') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-star"></i>Brand<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'realtor') ? 'active' : ''; ?>" href="<?php echo site_url('/realtor') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-user"></i>Realtor<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link <?php echo (uri_string() === 'brokerage') ? 'active' : ''; ?>" href="<?php echo site_url('/brokerage') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-user"></i>Brokerage<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link <?php echo (uri_string() === 'tour') ? 'active' : ''; ?>" href="<?php echo site_url('/tour') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-plane"></i>Visits<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link <?php echo (uri_string() === 'notification') ? 'active' : ''; ?>" href="<?php echo site_url('/notification') ?>" aria-expanded="false"><i class="fa-xs fa fa-fw fa-file"></i>Notifications<span class="badge badge-success">6</span></a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link <?php echo (uri_string() === 'system_option') ? 'active' : ''; ?>" href="<?php echo site_url('/system_option') ?>" aria-expanded="false"><i class="fa-xs fas fa-fw far fa-wrench"></i>System Option <span class="badge badge-success">6</span></a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>