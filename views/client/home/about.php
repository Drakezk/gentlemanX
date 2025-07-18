<?php include 'views/client/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
            <p><?= $content ?></p>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Thông tin dự án</h5>
                    <p class="card-text">
                        Đây là một dự án PHP MVC cơ bản được xây dựng theo mô hình:
                    </p>
                    <ul>
                        <li>Model-View-Controller (MVC)</li>
                        <li>Object-Oriented Programming (OOP)</li>
                        <li>Tách biệt Client và Admin</li>
                        <li>Database abstraction layer</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/client/layouts/footer.php'; ?>
