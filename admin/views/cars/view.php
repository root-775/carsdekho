<div class="container-fluid">
    <div class="row">

        <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="container mt-4">

                <?php include BASE_PATH . 'views/include/flash.php'; ?>


                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Cars</h4>
                    <a href="<?= BASE_URL ?>index.php?controller=cars&function=create" class="btn btn-primary">
                        + Add New Car
                    </a>
                </div>

                <table id="carsTable" class="display table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Car Name</th>
                            <th>Brand</th>
                            <th>Price Range</th>
                            <th>Fuel</th>
                            <th>Transmission</th>
                            <th>Image</th>
                            <th>Most Searched</th>
                            <th>Latest</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cars as $car): ?>
                            <tr>
                                <td><?= (int) $car['id'] ?></td>

                                <td><?= htmlspecialchars($car['name']) ?></td>

                                <td><?= htmlspecialchars($car['brand']) ?></td>

                                <td>
                                    ₹<?= number_format($car['price_from'], 2) ?>
                                    –
                                    ₹<?= number_format($car['price_to'], 2) ?>
                                </td>

                                <td><?= htmlspecialchars($car['fuel_type']) ?></td>

                                <td><?= htmlspecialchars($car['transmission']) ?></td>

                                <td>
                                    <?php if (!empty($car['image_path'])): ?>
                                        <img src="<?= BASE_URL . $car['image_path'] ?>" width="80" class="img-thumbnail">
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($car['is_most_searched'] == 1): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($car['is_latest'] == 1): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= date('F j, Y g:i A', strtotime($car['created_at'])) ?>
                                </td>

                                <td>
                                    <a href="<?= BASE_URL ?>index.php?controller=cars&function=edit&id=<?= (int) $car['id'] ?>"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <a href="<?= BASE_URL ?>index.php?controller=cars&function=deleteCar&id=<?= (int) $car['id'] ?>"
                                        class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
        </main>
    </div>
</div>