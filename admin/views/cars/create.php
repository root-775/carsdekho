<?php
if (isset($_POST['create'])) {
    $this->createCar($_POST, $_FILES);
}


?>

<div class="container-fluid">
  <div class="row">

    <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <?php include BASE_PATH . 'views/include/flash.php'; ?>

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="mb-0">Create Car</h4>
        <a href="index.php" class="btn btn-secondary">Back</a>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">

          <form id="carForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="create" value="1">

            <div class="row">
              <!-- Name -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Car Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <!-- Brand -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" required>
              </div>

              <!-- Price From -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Price From</label>
                <input type="number" step="0.01" min="0" name="price_from" class="form-control" required>
              </div>

              <!-- Price To -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Price To</label>
                <input type="number" step="0.01" min="0" name="price_to" class="form-control" required>
              </div>

              <!-- Fuel Type -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Fuel Type</label>
                <select name="fuel_type" class="form-select" required>
                  <option value="" selected>Select</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                  <option value="Electric">Electric</option>
                  <option value="Hybrid">Hybrid</option>
                </select>
              </div>

              <!-- Transmission -->
              <div class="col-md-3 mb-3">
                <label class="form-label">Transmission</label>
                <select name="transmission" class="form-select" required>
                  <option value="" selected>Select</option>
                  <option value="Manual">Manual</option>
                  <option value="Automatic">Automatic</option>
                  <option value="AMT">AMT</option>
                  <option value="CVT">CVT</option>
                  <option value="DCT">DCT</option>
                </select>
              </div>
            </div>

            <!-- Image Upload (Required on Create) -->
            <div class="mb-3">
              <label class="form-label">Car Image</label>
              <input type="file" name="image_path" class="form-control" accept="image/*" required>
              <div class="form-text">Allowed: JPG/PNG/WEBP. Max 2MB.</div>
            </div>

            <!-- Switches -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_most_searched" value="1">
                  <label class="form-check-label">Most Searched</label>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_latest" value="1">
                  <label class="form-check-label">Latest</label>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
              <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-success">Save Car</button>
            </div>

          </form>

        </div>
      </div>

    </main>
  </div>
</div>
