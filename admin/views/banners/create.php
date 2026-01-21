<?php
if (isset($_POST['create'])) {

    $result = $this->createBannerPost($_POST, $_FILES);

    if (isset($result['ok']) && $result['ok'] == true) {
        echo '<script>alert("congratulations Banner created successfully :)");</script>';
        header('location: index.php?controller=banners&function=view');
    }

}
?>


<div class="container-fluid">
    <div class="row">

        <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <?php include BASE_PATH . 'views/include/flash.php'; ?>

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form id="bannerForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="create" value="1">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Button Link</label>
                            <input type="url" name="button_link" class="form-control" placeholder="https://example.com"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Banner Image</label>
                            <input type="file" name="image_path" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" min="1" value="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                Save Banner
                            </button>
                        </div>

                    </form>

                </div>
            </div>



        </main>
    </div>
</div>