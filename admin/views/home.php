    
    


    <div class="container-fluid">
        <div class="row">
            
            <?php include BASE_PATH . 'views/include/siderbar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <?php include BASE_PATH . 'views/include/flash.php'; ?>
                
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <i class="bi bi-calendar"></i>
                            This week
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Cars</div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $totalCars['total_cars'] ?? 0?></h5>
                                <p class="card-text">Total car registered.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Banners</div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $totalBanners['total_banners'] ?? 0?></h5>
                                <p class="card-text">Total Banners.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Issues</div>
                            <div class="card-body">
                                <h5 class="card-title">12</h5>
                                <p class="card-text">Open support tickets pending.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Recent Cars</h2>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Car Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Price Range</th>
                                <th scope="col">Fuel</th>
                                <th scope="col">Image</th>
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

                                    <td>
                                        <?php if (!empty($car['image_path'])): ?>
                                            <img src="<?= BASE_URL . $car['image_path'] ?>" width="80" class="img-thumbnail">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
