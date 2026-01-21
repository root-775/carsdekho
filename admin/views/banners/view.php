<?php

$banners = $this->model->getAllBanners();
?>

<div class="container-fluid">
    <div class="row">

        <?php include BASE_PATH . 'views/include/siderbar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <div class="container mt-4">
                
                <?php include BASE_PATH . 'views/include/flash.php'; ?>
            

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Banners</h4>
                    <a href="<?=BASE_URL?>index.php?controller=banners&function=create" class="btn btn-primary">
                        + Add New Banner
                    </a>
                </div>

                <table id="bannerTable" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Button Text</th>
                            <th>Button Link</th>
                            <th>Image</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($banners as $banner):  ?>
                        <tr>
                            <td><?= $banner['id'] ?></td>
                            <td><?= $banner['title'] ?></td>
                            <td><?= $banner['subtitle'] ?></td>
                            <td><?= $banner['button_text'] ?></td>
                            <td>
                                <a href="<?= $banner['button_link'] ?>">
                                    <?= $banner['button_link'] ?>
                                </a>
                            </td>
                            <td>
                                <img src="<?=BASE_URL . $banner['image_path'] ?>" width="80">
                            </td>
                            <td>1</td>
                            <td>
                                <?php if ($banner['is_active'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('F j, Yg:i A', strtotime($banner['created_at'])) ?>
                            </td>
                            <td>
                                <a href="<?=BASE_URL?>index.php?controller=banners&function=edit&id=<?= $banner['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?=BASE_URL?>index.php?controller=banners&function=deleteBanner&id=<?= $banner['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </main>
    </div>
</div>