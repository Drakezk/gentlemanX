<?php include 'views/admin/layouts/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Thêm sản phẩm mới</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Mã SKU</label>
                <input type="text" name="sku" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Danh mục (category_id)</label>
                <input type="number" name="category_id" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Thương hiệu (brand_id)</label>
                <input type="number" name="brand_id" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá bán</label>
                <input type="number" name="price" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="compare_price" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock_quantity" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured">
                    <label class="form-check-label" for="is_featured">
                        Nổi bật
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh đại diện (đường dẫn)</label>
                <input type="text" name="featured_image" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả ngắn</label>
            <textarea name="short_description" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
        <a href="<?php echo Helper::url('admin/product/index'); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
