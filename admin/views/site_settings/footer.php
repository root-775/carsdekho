<?php
if (isset($_POST['create'])) {
    $this->createFooterSettings($_POST, $_FILES);
}


if (isset($_POST['update'])) {
    $this->updateFooterSettings($_POST, $_FILES);
}


?>
<div class="container-fluid">
  <div class="row">

    <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <?php include BASE_PATH . 'views/include/flash.php'; ?>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Footer Settings</h4>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form method="post">
            <input type="hidden" name="<?= !empty($footer) ? 'update' : 'create' ?>" value="1">

            <div class="mb-3">
              <label class="form-label">About Text</label>
              <textarea name="about_text" class="form-control" rows="4" required><?= htmlspecialchars($footer['about_text'] ?? '', ENT_QUOTES) ?></textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control"
                       value="<?= htmlspecialchars($footer['address'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="<?= htmlspecialchars($footer['phone'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($footer['email'] ?? '', ENT_QUOTES) ?>" required>
              </div>
            </div>

            <hr class="my-4">

            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Facebook URL</label>
                <input type="url" name="facebook" class="form-control"
                       placeholder="https://facebook.com/yourpage"
                       value="<?= htmlspecialchars($footer['facebook'] ?? '', ENT_QUOTES) ?>">
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">Instagram URL</label>
                <input type="url" name="instagram" class="form-control"
                       placeholder="https://instagram.com/yourprofile"
                       value="<?= htmlspecialchars($footer['instagram'] ?? '', ENT_QUOTES) ?>">
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label">YouTube URL</label>
                <input type="url" name="youtube" class="form-control"
                       placeholder="https://youtube.com/@yourchannel"
                       value="<?= htmlspecialchars($footer['youtube'] ?? '', ENT_QUOTES) ?>">
              </div>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-success">
                <?= !empty($footer) ? 'Update Footer Settings' : 'Save Footer Settings' ?>
              </button>
            </div>

          </form>

        </div>
      </div>

    </main>
  </div>
</div>
