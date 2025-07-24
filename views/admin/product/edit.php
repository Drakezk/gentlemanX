<?php include 'views/admin/layouts/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Sửa sản phẩm</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control"
                       value="<?php echo Helper::e($product['name']); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control"
                       value="<?php echo Helper::e($product['slug']); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Mã SKU</label>
                <input type="text" name="sku" class="form-control"
                       value="<?php echo Helper::e($product['sku']); ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Danh mục (category_id)</label>
                <input type="number" name="category_id" class="form-control"
                       value="<?php echo $product['category_id']; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Thương hiệu (brand_id)</label>
                <input type="number" name="brand_id" class="form-control"
                       value="<?php echo $product['brand_id']; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá bán</label>
                <input type="number" name="price" class="form-control"
                       value="<?php echo $product['price']; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="compare_price" class="form-control"
                       value="<?php echo $product['compare_price']; ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock_quantity" class="form-control"
                       value="<?php echo $product['stock_quantity']; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="active" <?php echo $product['status']=='active'?'selected':''; ?>>Active</option>
                    <option value="inactive" <?php echo $product['status']=='inactive'?'selected':''; ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                        <?php echo $product['is_featured'] ? 'checked' : ''; ?>>
                    <label class="form-check-label">Nổi bật</label>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh đại diện hiện tại</label><br>
                <?php if ($product['featured_image']): ?>
                    <img src="<?php echo UPLOAD_URL . $product['featured_image']; ?>" style="height:60px;">
                <?php else: ?>
                    <p>Chưa có ảnh</p>
                <?php endif; ?>
                <input type="file" name="featured_image" class="form-control mt-2">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gallery hiện tại</label><br>
            <?php $gallery = json_decode($product['gallery'], true); ?>
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $img): ?>
                    <img src="<?php echo UPLOAD_URL . $img; ?>" style="height:60px; margin-right:5px;">
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có gallery</p>
            <?php endif; ?>
            <input type="file" name="gallery[]" class="form-control mt-2" multiple>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả ngắn</label>
            <textarea name="short_description" class="form-control" rows="2"><?php echo Helper::e($product['short_description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="4"><?php echo Helper::e($product['description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="<?php echo Helper::url('admin/product/index'); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
