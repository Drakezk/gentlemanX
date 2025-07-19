<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? Helper::e($title) . ' - Admin Panel' : 'Admin Panel' ?></title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Helper::asset('css/admin.css') ?>">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h4><?php echo APP_NAME ?></h4>
                <small>Admin Panel</small>
            </div>
            
            <ul class="list-unstyled components">
                <li>
                    <a href="<?php echo Helper::url('admin') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                <!-- Products Management -->
                <li>
                    <a href="#productSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">
                        <i class="fas fa-box"></i> Quản lý sản phẩm
                    </a>
                    <ul class="collapse list-unstyled" id="productSubmenu">
                        <li><a href="<?php echo Helper::url('admin/product') ?>">Danh sách sản phẩm</a></li>
                        <li><a href="<?php echo Helper::url('admin/product/create') ?>">Thêm sản phẩm</a></li>
                        <li><a href="<?php echo Helper::url('admin/category') ?>">Danh mục</a></li>
                        <li><a href="<?php echo Helper::url('admin/brand') ?>">Thương hiệu</a></li>
                    </ul>
                </li>
                
                <!-- Orders Management -->
                <li>
                    <a href="<?php echo Helper::url('admin/order') ?>">
                        <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                    </a>
                </li>
                
                <!-- Users Management -->
                <li>
                    <a href="#userSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">
                        <i class="fas fa-users"></i> Quản lý người dùng
                    </a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li><a href="<?php echo Helper::url('admin/user') ?>">Khách hàng</a></li>
                        <li><a href="<?php echo Helper::url('admin/admin') ?>">Quản trị viên</a></li>
                    </ul>
                </li>
                
                <!-- Content Management -->
                <li>
                    <a href="#contentSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">
                        <i class="fas fa-file-alt"></i> Quản lý nội dung
                    </a>
                    <ul class="collapse list-unstyled" id="contentSubmenu">
                        <li><a href="<?php echo Helper::url('admin/page') ?>">Trang tĩnh</a></li>
                        <li><a href="<?php echo Helper::url('admin/banner') ?>">Banner</a></li>
                        <li><a href="<?php echo Helper::url('admin/contact') ?>">Tin nhắn liên hệ</a></li>
                    </ul>
                </li>
                
                <!-- Settings -->
                <li>
                    <a href="<?php echo Helper::url('admin/setting') ?>">
                        <i class="fas fa-cog"></i> Cài đặt
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                       
                    <div class="ms-auto d-flex align-items-center">
                        <!-- Notifications -->
                        <div class="dropdown me-3">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="badge bg-danger">3</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Thông báo</h6></li>
                                <li><a class="dropdown-item" href="#">Đơn hàng mới #1234</a></li>
                                <li><a class="dropdown-item" href="#">Sản phẩm sắp hết hàng</a></li>
                                <li><a class="dropdown-item" href="#">Tin nhắn liên hệ mới</a></li>
                            </ul>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <?php echo Helper::e($currentUser['name'] ?? ''); ?>

                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo Helper::url('admin/profile') ?>">
                                    <i class="fas fa-user-edit"></i> Hồ sơ
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo Helper::url() ?>" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Xem website
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo Helper::url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Flash Messages -->
            <?php 
            $flashMessages = Session::getAllFlash();
            foreach ($flashMessages as $type => $message): 
            ?>
                <div class="alert alert-<?php echo $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show m-3" role="alert">
                    <?php echo Helper::e($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>

            <!-- Page Content -->
            <div class="container-fluid p-4">
