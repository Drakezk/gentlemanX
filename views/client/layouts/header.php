<?php
if (!class_exists('CartItem')) {
    require_once __DIR__ . '/../../../models/CartItem.php';
}
$cartItemModel = new CartItem();
$userId = $_SESSION['user']['id'] ?? null;
$sessionId = session_id();
$cartCount = $cartItemModel->countItems($userId, $sessionId);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? Helper::e($title) . ' - ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Meta tags -->
    <meta name="description" content="<?php echo isset($meta_description) ? Helper::e($meta_description) : 'Website thương mại điện tử' ?>">
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? Helper::e($meta_keywords) : 'ecommerce, shopping' ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Helper::asset('css/client.css') ?>">
    <link rel="stylesheet" href="<?php echo Helper::asset('css/header.css') ?>">
    <link rel="stylesheet" href="<?php echo Helper::asset('css/nav.css') ?>">
</head>
<body>
    <!-- Header -->
<header id="mainHeader" class="header shadow-sm sticky-top">
    <!-- Top Bar -->
    <div class="top-bar bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center small flex-wrap">
            <div class="contact-info">
                <span><i class="fas fa-phone me-1"></i> 0123 456 789</span>
                <span class="ms-3"><i class="fas fa-envelope me-1"></i> support@gentlemanx.com</span>
            </div>
            <div class="top-links mt-2 mt-md-0">
                <a href="<?php echo Helper::url('auth/account') ?>" class="text-white text-decoration-none me-3">Theo dõi đơn hàng</a>
                <a href="<?php echo Helper::url('home/shop') ?>" class="text-white text-decoration-none me-3">Cửa hàng</a>
                <a href="<?php echo Helper::url('contact/index') ?>" class="text-white text-decoration-none">Liên hệ</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header py-3 border-bottom bg-white">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <!-- Logo -->
            <a href="<?php echo Helper::url() ?>" class="logo fw-bold fs-3 text-dark text-decoration-none">
                Gentleman<span class="text-primary">X</span>
            </a>

            <!-- Search bar -->
            <form action="<?php echo Helper::url('product/search') ?>" method="GET" class="search-bar d-flex mt-3 mt-md-0 flex-grow-1 mx-md-5" style="max-width: 500px;">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm thời trang nam..."
                    value="<?php echo Helper::e($this->get('q', '')) ?>">
                <button type="submit" class="btn btn-dark ms-2"><i class="fas fa-search"></i></button>
            </form>

            <!-- Actions -->
            <div class="header-actions d-flex align-items-center mt-3 mt-md-0">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?php echo Helper::url('wishlist/index') ?>" class="text-dark me-3" title="Yêu thích">
                        <i class="fas fa-heart fs-5"></i>
                    </a>
                <?php endif; ?>

                <a href="<?php echo Helper::url('cart') ?>" class="text-dark me-3 position-relative" title="Giỏ hàng">
                    <i class="fas fa-shopping-bag fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo isset($cartCount) ? $cartCount : 0 ?>
                    </span>
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="<?php echo Helper::url('auth/account') ?>" class="text-dark me-2" title="Tài khoản">
                        <i class="fas fa-user fs-5"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo Helper::url('auth/login') ?>" class="text-dark me-2">Đăng nhập</a> /
                    <a href="<?php echo Helper::url('auth/register') ?>" class="text-dark ms-2">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
        require_once __DIR__ . '/../../../models/Category.php';
        $categoryModel = new Category();
        $navCategories = $categoryModel->getCategoryTree(); // chỉ lấy danh mục cha
    ?>

    <!-- Navigation -->
    <nav class="nav bg-light border-top">
        <div class="container">
            <ul class="nav justify-content-center fw-semibold flex-wrap">
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo Helper::url(); ?>">Trang chủ</a>
            </li>

            <?php foreach ($navCategories as $cat): ?>
                <?php if (!empty($cat['children'])): ?>
                    <!-- Có danh mục con -->
                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark" href="<?php echo Helper::url('home/productList?category=' . $cat['slug']); ?>" id="navDropdown<?= $cat['id'] ?>" role="button">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navDropdown<?= $cat['id'] ?>">
                            <?php foreach ($cat['children'] as $child): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo Helper::url('home/productList?category=' . $child['slug']); ?>">
                                        <?php echo htmlspecialchars($child['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Không có danh mục con -->
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?php echo Helper::url('home/productList?category=' . $cat['slug']); ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

            <li class="nav-item">
                <a class="nav-link text-danger" href="<?php echo Helper::url('home/productList?sort=sale'); ?>">Sale</a>
            </li>
            </ul>
        </div>
    </nav>

</header>

<script src="<?php echo Helper::asset('js/header.js'); ?>"></script>

<main>
