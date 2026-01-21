<?php
include_once "admin/model/db.php";

define('ASSET_URL', 'http://localhost/carsdekho/admin/');
$db = new dbModel();

$site_settings = $db->selectOne("SELECT * FROM site_settings");
$footer_settings = $db->selectOne("SELECT * FROM footer_settings");
$banners = $db->select("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC");
$mostSearched = $db->select("SELECT * FROM cars WHERE is_most_searched = 1 ORDER BY id DESC limit 8");
$latestCars = $db->select("SELECT * FROM cars WHERE is_latest = 1 ORDER BY id DESC limit 8");

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($site_settings["site_name"] ?? "") ?> - Home</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Theme-like clean UI */
        .navbar-brand img {
            height: 34px;
        }

        .hero-slide {
            min-height: 340px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: 18px;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, .65), rgba(0, 0, 0, .15));
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .section-title {
            font-weight: 700;
        }

        .car-card {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .08);
            transition: transform .18s ease, box-shadow .18s ease;
            height: 100%;
        }

        .car-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, .12);
        }

        .car-thumb {
            height: 170px;
            object-fit: cover;
        }

        .badge-soft {
            background: rgba(13, 110, 253, .1);
            color: #0d6efd;
            font-weight: 600;
        }

        footer a {
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="<?= ASSET_URL.htmlspecialchars($site_settings["logo_path"] ?? "") ?>" alt="Logo" onerror="this.style.display='none'">
                <span class="fw-bold"><?= htmlspecialchars($site_settings["site_name"] ?? "") ?></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="#most">Most Searched</a></li>
                    <li class="nav-item"><a class="nav-link" href="#latest">Latest Cars</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">Contact</a></li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-2" href="#most">Search</a>
                    </li>
                </ul>

                <div class="d-none d-lg-flex align-items-center ms-3 text-muted small">
                    <span class="me-3">📞 <?= htmlspecialchars($site_settings["header_phone"]) ?></span>
                    <span>✉️ <?= htmlspecialchars($site_settings["header_email"]) ?></span>
                </div>
            </div>
        </div>
    </nav>

    <section class="py-4">
        <div class="container">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($banners as $i => $b): ?>
                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                            <div class="hero-slide p-4 p-md-5 d-flex align-items-center"
                                style="background-image:url('<?= ASSET_URL.htmlspecialchars($b["image_path"]) ?>');">
                                <div class="hero-overlay"></div>
                                <div class="hero-content text-white col-lg-7">
                                    <h1 class="display-6 fw-bold mb-2"><?= htmlspecialchars($b["title"]) ?></h1>
                                    <p class="lead mb-4"><?= htmlspecialchars($b["subtitle"]) ?></p>
                                    <a class="btn btn-warning fw-semibold" href="<?= htmlspecialchars($b["button_link"]) ?>">
                                        <?= htmlspecialchars($b["button_text"]) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section id="most" class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h2 class="section-title mb-0">Most Searched Cars</h2>
                    <p class="text-muted mb-0">Popular choices people are exploring right now</p>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
            </div>

            <div class="row g-4">
                <?php foreach ($mostSearched as $car): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card car-card">
                            <img class="car-thumb w-100" src="<?= ASSET_URL.htmlspecialchars($car["image_path"]) ?>"
                                alt="<?= htmlspecialchars($car["name"]) ?>">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($car["name"]) ?></h5>
                                    <span class="badge badge-soft rounded-pill">Hot</span>
                                </div>
                                <div class="text-muted small mb-2"><?= htmlspecialchars($car["fuel_type"]) ?></div>
                                <div class="fw-semibold"><?= htmlspecialchars($car["price_from"]) ?> - <?= htmlspecialchars($car["price_to"]) ?></div>
                                <div class="d-grid mt-3">
                                    <a href="#" class="btn btn-primary btn-sm">Check Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="latest" class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h2 class="section-title mb-0">Latest Cars</h2>
                    <p class="text-muted mb-0">New launches & recently added models</p>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
            </div>

            <div class="row g-4">
                <?php foreach ($latestCars as $car): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card car-card">
                            <img class="car-thumb w-100" src="<?= ASSET_URL.htmlspecialchars($car["image_path"]) ?>"
                                alt="<?= htmlspecialchars($car["name"]) ?>">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($car["name"]) ?></h5>
                                    <span class="badge bg-success-subtle text-success rounded-pill">New</span>
                                </div>
                                <div class="text-muted small mb-2"><?= htmlspecialchars($car["fuel_type"]) ?></div>
                                <div class="fw-semibold"><?= htmlspecialchars($car["price_from"]) ?> - <?= htmlspecialchars($car["price_to"]) ?></div>
                                <div class="d-grid mt-3">
                                    <a href="#" class="btn btn-dark btn-sm">Compare</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer id="footer" class="pt-5 pb-4 bg-dark text-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($site_settings["site_name"]) ?></h5>
                    <p class="text-white-50 mb-3">
                        <?= $footer_settings['about_text'] ?>
                    </p>
                    <p class="text-white-50 mb-3">
                        <?= $footer_settings['address'] ?>
                    </p>
                    <div class="small text-white-50">📞 <?= htmlspecialchars($footer_settings['phone']) ?></div>
                    <div class="small text-white-50">✉️ <?= htmlspecialchars($footer_settings['email']) ?></div>
                </div>

                <div class="col-6 col-md-2">
                    <h6 class="fw-semibold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a class="text-white-50" href="#most">Most Searched</a></li>
                        <li><a class="text-white-50" href="#latest">Latest Cars</a></li>
                        <li><a class="text-white-50" href="#">Compare</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-2">
                    <h6 class="fw-semibold">Social Links</h6>
                    <ul class="list-unstyled">
                        <li><a class="text-white-50" href="<?= $footer_settings['facebook'] ?>">Facebook</a></li>
                        <li><a class="text-white-50" href="<?= $footer_settings['instagram'] ?>">Instagram</a></li>
                        <li><a class="text-white-50" href="<?= $footer_settings['youtube'] ?>">Youtube</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-4">
                    <h6 class="fw-semibold">Newsletter</h6>
                    <p class="text-white-50 small">Get updates on latest launches and offers.</p>
                    <form class="d-flex gap-2">
                        <input class="form-control" type="email" placeholder="Email address">
                        <button class="btn btn-warning fw-semibold" type="button">Subscribe</button>
                    </form>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="text-white-50 small">© <?= date('Y') ?> <?= htmlspecialchars($site_settings["site_name"]) ?>. All
                    rights reserved.</div>
                <div class="d-flex gap-3">
                    <a class="text-white-50 small" href="#">Privacy</a>
                    <a class="text-white-50 small" href="#">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>