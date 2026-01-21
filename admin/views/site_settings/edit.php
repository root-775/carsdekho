<?php
if (isset($_POST['create'])) {
    $this->createSettings($_POST, $_FILES);
}


if (isset($_POST['update'])) {
    $this->updateSettings($_POST, $_FILES);
}


?>

<div class="container-fluid">
  <div class="row">

    <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <?php include BASE_PATH . 'views/include/flash.php'; ?>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Site Settings</h4>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= !empty($settings) ? 'update' : 'create' ?>" value="1">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control"
                       value="<?= htmlspecialchars($settings['site_name'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Header Phone</label>
                <input type="text" name="header_phone" class="form-control"
                       value="<?= htmlspecialchars($settings['header_phone'] ?? '', ENT_QUOTES) ?>"
                       placeholder="e.g. +91 98765 43210" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Header Email</label>
                <input type="email" name="header_email" class="form-control"
                       value="<?= htmlspecialchars($settings['header_email'] ?? '', ENT_QUOTES) ?>"
                       placeholder="e.g. support@example.com" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Logo (<?= !empty($settings['logo_path']) ? 'optional' : 'required' ?>)</label>
                <input type="file" name="logo_path" class="form-control" accept="image/*" <?= empty($settings['logo_path']) ? 'required' : '' ?>>
                <div class="form-text">Allowed: JPG/PNG/WEBP. Max 2MB.</div>
              </div>
            </div>

            <?php if (!empty($settings['logo_path'])): ?>
              <div class="mb-3">
                <label class="form-label d-block">Current Logo</label>
                <img src="<?= htmlspecialchars(BASE_URL . $settings['logo_path'], ENT_QUOTES) ?>"
                     class="img-thumbnail" style="max-height: 90px;" alt="Logo">
              </div>
            <?php endif; ?>

            <div class="d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-success">
                <?= !empty($settings) ? 'Update Settings' : 'Save Settings' ?>
              </button>
            </div>

          </form>

        </div>
      </div>

    </main>
  </div>
</div>
