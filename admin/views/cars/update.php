<?php
if (isset($_POST['update'])) {

    $this->updateCar($_POST, $_FILES);

}
?>

<div class="container-fluid">
  <div class="row">

    <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <?php include BASE_PATH . 'views/include/flash.php'; ?>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Update Car</h4>
        <a href="index.php" class="btn btn-secondary">Back</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form id="carForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?= (int)($car['id'] ?? 0) ?>">

            <div class="row">
              <!-- Name -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Car Name</label>
                <input type="text" name="name" class="form-control"
                  value="<?= htmlspecialchars($car['name'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <!-- Brand -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control"
                  value="<?= htmlspecialchars($car['brand'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <!-- Price From -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Price From</label>
                <input type="number" step="0.01" min="0" name="price_from" class="form-control"
                  value="<?= htmlspecialchars($car['price_from'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <!-- Price To -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Price To</label>
                <input type="number" step="0.01" min="0" name="price_to" class="form-control"
                  value="<?= htmlspecialchars($car['price_to'] ?? '', ENT_QUOTES) ?>" required>
              </div>

              <!-- Fuel Type -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Fuel Type</label>
                <?php $fuel = (string)($car['fuel_type'] ?? ''); ?>
                <select name="fuel_type" class="form-select" required>
                  <option value="" <?= $fuel === '' ? 'selected' : '' ?>>Select</option>
                  <option value="Petrol" <?= $fuel === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                  <option value="Diesel" <?= $fuel === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                  <option value="CNG" <?= $fuel === 'CNG' ? 'selected' : '' ?>>CNG</option>
                  <option value="Electric" <?= $fuel === 'Electric' ? 'selected' : '' ?>>Electric</option>
                  <option value="Hybrid" <?= $fuel === 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                </select>
              </div>

              <!-- Transmission -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Transmission</label>
                <?php $trans = (string)($car['transmission'] ?? ''); ?>
                <select name="transmission" class="form-select" required>
                  <option value="" <?= $trans === '' ? 'selected' : '' ?>>Select</option>
                  <option value="Manual" <?= $trans === 'Manual' ? 'selected' : '' ?>>Manual</option>
                  <option value="Automatic" <?= $trans === 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                  <option value="AMT" <?= $trans === 'AMT' ? 'selected' : '' ?>>AMT</option>
                  <option value="CVT" <?= $trans === 'CVT' ? 'selected' : '' ?>>CVT</option>
                  <option value="DCT" <?= $trans === 'DCT' ? 'selected' : '' ?>>DCT</option>
                </select>
              </div>
            </div>

            <!-- Current Image Preview -->
            <?php if (!empty($car['image_path'])): ?>
              <div class="mb-3">
                <label class="form-label d-block">Current Image</label>
                <img
                  src="<?= htmlspecialchars(BASE_URL . $car['image_path'], ENT_QUOTES) ?>"
                  alt="Car Image"
                  class="img-thumbnail"
                  style="max-height: 120px;"
                >
              </div>
            <?php endif; ?>

            <!-- Change Image -->
            <div class="mb-3">
              <label class="form-label">Change Image (optional)</label>
              <input type="file" name="image_path" class="form-control" accept="image/*">
              <div class="form-text">Allowed: JPG/PNG/WEBP. Max 2MB.</div>
            </div>

            <!-- Switches -->
            <?php
              $most = (int)($car['is_most_searched'] ?? 0);
              $latest = (int)($car['is_latest'] ?? 0);
            ?>
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_most_searched" value="1"
                    <?= $most === 1 ? 'checked' : '' ?>>
                  <label class="form-check-label">Most Searched</label>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_latest" value="1"
                    <?= $latest === 1 ? 'checked' : '' ?>>
                  <label class="form-check-label">Latest</label>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-success">Update Car</button>
            </div>

          </form>

        </div>
      </div>

    </main>
  </div>
</div>
