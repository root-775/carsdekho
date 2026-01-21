<?php
session_start();

class carsController
{
    public $model;


    function __construct()
    {
        include_once BASE_PATH . 'model/cars.php';
        $this->model = new carsModel();

    }

    function sessionCheck()
    {
        if (!isset($_SESSION["is_login"])) {
            header('location: index.php?controller=admin&function=login');
        }
    }

    function view()
    {
        $this->sessionCheck();
        $cars = $this->model->getAllCars();
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/cars/view.php';
        include BASE_PATH . 'views/include/footer.php';
    }

    public function create()
    {
        $this->sessionCheck();
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/cars/create.php';
        include BASE_PATH . 'views/include/footer.php';
    }


    function createCar($post, $files)
    {
        $this->sessionCheck();
        
        $name = trim($post['name'] ?? '');
        $brand = trim($post['brand'] ?? '');
        $price_from = $post['price_from'] ?? '';
        $price_to = $post['price_to'] ?? '';
        $fuel_type = trim($post['fuel_type'] ?? '');
        $transmission = trim($post['transmission'] ?? '');

        $is_most_searched = isset($post['is_most_searched']) ? 1 : 0;
        $is_latest = isset($post['is_latest']) ? 1 : 0;

        
        if (
            $name === '' || $brand === '' || $fuel_type === '' || $transmission === '' ||
            $price_from === '' || $price_to === ''
        ) {
            setFlash('danger', 'All fields are required.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        if (!is_numeric($price_from) || !is_numeric($price_to)) {
            setFlash('danger', 'Price must be numeric.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        if ((float) $price_from > (float) $price_to) {
            setFlash('danger', 'Price From cannot be greater than Price To.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        // 3. Image validation
        if (!isset($files['image_path']) || $files['image_path']['error'] !== UPLOAD_ERR_OK) {
            setFlash('danger', 'Car image is required.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        $img = $files['image_path'];

        if ($img['size'] > 2 * 1024 * 1024) {
            setFlash('danger', 'Image must be less than 2MB.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($img['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            setFlash('danger', 'Only JPG, PNG, or WEBP images allowed.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        // 4. Upload image
        $uploadDir = $this->carUploadDir();
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'car_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
        $destPath = $uploadDir . $fileName;

        if (!move_uploaded_file($img['tmp_name'], $destPath)) {
            setFlash('danger', 'Failed to upload image.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        $image_path = 'uploads/cars/' . $fileName;

        $params = [
            $name,
            $brand,
            (float) $price_from,
            (float) $price_to,
            $fuel_type,
            $transmission,
            $image_path,
            $is_most_searched,
            $is_latest
        ];

        $ok = $this->model->create($params);

        if (!$ok) {
            @unlink($destPath);
            setFlash('danger', 'Database insert failed.');
            header('Location: index.php?controller=cars&function=create');
            exit;
        }

        // 6. Redirect
        setFlash('success', 'Car created successfully.');
        header('Location: index.php?controller=cars&function=view');
        exit;
    }


    public function edit()
    {
        $this->sessionCheck();

        $car = $this->model->getCar($_GET['id'] ?? '');
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/cars/update.php';
        include BASE_PATH . 'views/include/footer.php';
    }


    function updateCar($post, $files)
    {
        $this->sessionCheck();

        $id = $post['id'] ?? '';

        if (!ctype_digit((string)$id) || (int)$id < 1) {
            setFlash('danger', 'Invalid car ID.');
            header('Location: index.php?controller=cars&function=view');
            exit;
        }
        $id = (int)$id;

        $car = $this->model->getCar($id);
        if (!$car) {
            setFlash('danger', 'Car not found.');
            header('Location: index.php?controller=cars&function=view');
            exit;
        }

        $name         = trim($post['name'] ?? '');
        $brand        = trim($post['brand'] ?? '');
        $price_from   = $post['price_from'] ?? '';
        $price_to     = $post['price_to'] ?? '';
        $fuel_type    = trim($post['fuel_type'] ?? '');
        $transmission = trim($post['transmission'] ?? '');

        $is_most_searched = isset($post['is_most_searched']) ? 1 : 0;
        $is_latest        = isset($post['is_latest']) ? 1 : 0;

        if ($name === '' || $brand === '' || $fuel_type === '' || $transmission === '' || $price_from === '' || $price_to === '') {
            setFlash('danger', 'All fields are required.');
            header('Location: index.php?controller=cars&function=edit&id=' . $id);
            exit;
        }

        if (!is_numeric($price_from) || !is_numeric($price_to)) {
            setFlash('danger', 'Price must be numeric.');
            header('Location: index.php?controller=cars&function=edit&id=' . $id);
            exit;
        }

        if ((float)$price_from > (float)$price_to) {
            setFlash('danger', 'Price From cannot be greater than Price To.');
            header('Location: index.php?controller=cars&function=edit&id=' . $id);
            exit;
        }

        $new_image_path = $car['image_path'] ?? '';
        $newFileUploaded = false;
        $newDestPath = '';

        if (isset($files['image_path']) && $files['image_path']['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($files['image_path']['error'] !== UPLOAD_ERR_OK) {
                setFlash('danger', 'Image upload error.');
                header('Location: index.php?controller=cars&function=edit&id=' . $id);
                exit;
            }

            $img = $files['image_path'];

            if ($img['size'] > 2 * 1024 * 1024) {
                setFlash('danger', 'Image must be less than 2MB.');
                header('Location: index.php?controller=cars&function=edit&id=' . $id);
                exit;
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($img['tmp_name']);

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($allowed[$mime])) {
                setFlash('danger', 'Only JPG, PNG, or WEBP images allowed.');
                header('Location: index.php?controller=cars&function=edit&id=' . $id);
                exit;
            }

            $uploadDir = $this->carUploadDir();
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = 'car_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
            $newDestPath = $uploadDir . $fileName;

            if (!move_uploaded_file($img['tmp_name'], $newDestPath)) {
                setFlash('danger', 'Failed to upload image.');
                header('Location: index.php?controller=cars&function=edit&id=' . $id);
                exit;
            }

            $new_image_path = 'uploads/cars/' . $fileName;
            $newFileUploaded = true;
        }

        $params = [
            $name,
            $brand,
            (float)$price_from,
            (float)$price_to,
            $fuel_type,
            $transmission,
            $new_image_path,
            $is_most_searched,
            $is_latest,
            $id
        ];

        $ok = $this->model->update( $params);

        if (!$ok) {
            if ($newFileUploaded && $newDestPath) {
                @unlink($newDestPath);
            }
            setFlash('danger', 'Database update failed.');
            header('Location: index.php?controller=cars&function=edit&id=' . $id);
            exit;
        }

        if ($newFileUploaded && !empty($car['image_path'])) {
            $oldDisk = BASE_PATH.$car['image_path'];
            if (is_file($oldDisk)) {
                @unlink($oldDisk);
            }
        }

        setFlash('success', 'Car updated successfully.');
        header('Location: index.php?controller=cars&function=view');
        exit;
    }



    function deleteCar()
    {
        $this->sessionCheck();

        $id = $_GET['id'] ?? '';
        if (!ctype_digit((string)$id) || (int)$id < 1) {
            setFlash('danger', 'Invalid car ID.');
            header('Location: index.php?controller=cars&function=view');
            exit;
        }
        $id = (int)$id;

        $car = $this->model->getCar($id);
        if (!$car) {
            setFlash('danger', 'Car not found.');
            header('Location: index.php?controller=cars&function=view');
            exit;
        }

        $ok = $this->model->deleteCar($id);

        if (!$ok) {
            setFlash('danger', 'Database delete failed.');
            header('Location: index.php?controller=cars&function=view');
            exit;
        }

        // delete image file after DB delete
        if (!empty($car['image_path'])) {
            $diskPath = BASE_PATH.$car['image_path'];
            if (is_file($diskPath)) {
                @unlink($diskPath);
            }
        }

        setFlash('success', 'Car deleted successfully.');
        header('Location: index.php?controller=cars&function=view');
        exit;
    }



    public function carUploadDir()
    {
        $this->sessionCheck();
        return BASE_PATH . 'uploads/cars/';
    }

}