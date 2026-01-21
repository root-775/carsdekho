<?php
session_start();

class bannersController
{
    public $model;


    function __construct()
    {
        include_once BASE_PATH. 'model/banners.php';
        $this->model = new bannersModel();

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
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/banners/view.php';
        include BASE_PATH . 'views/include/footer.php';
    }


    function create()
    {
        $this->sessionCheck();
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/banners/create.php';
        include BASE_PATH . 'views/include/footer.php';
    }

    public function createBannerPost($post, $files)
    {
        $this->sessionCheck();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($post['title'] ?? '');
            $subtitle = trim($post['subtitle'] ?? '');
            $button_text = trim($post['button_text'] ?? '');
            $button_link = trim($post['button_link'] ?? '');
            $sort_order = $post['sort_order'] ?? '';
            $is_active = $post['is_active'] ?? '1';

            if ($title === '' || $subtitle === '' || $button_text === '' || $button_link === '') {
                return ['ok' => false, 'message' => 'All fields are required.'];
            }

            if (!filter_var($button_link, FILTER_VALIDATE_URL)) {
                return ['ok' => false, 'message' => 'Please enter a valid button link URL.'];
            }

            if (!ctype_digit((string) $sort_order) || (int) $sort_order < 1) {
                return ['ok' => false, 'message' => 'Sort order must be a positive number.'];
            }
            $sort_order = (int) $sort_order;

            if (!in_array((string) $is_active, ['0', '1'], true)) {
                return ['ok' => false, 'message' => 'Invalid status value.'];
            }
            $is_active = (int) $is_active;

            if (!isset($files['image_path']) || $files['image_path']['error'] !== UPLOAD_ERR_OK) {
                return ['ok' => false, 'message' => 'Please upload a banner image.'];
            }

            $img = $files['image_path'];

            if ($img['size'] > 2 * 1024 * 1024) {
                return ['ok' => false, 'message' => 'Image size must be less than 2MB.'];
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($img['tmp_name']);

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($allowed[$mime])) {
                return ['ok' => false, 'message' => 'Only JPG, PNG, or WEBP images are allowed.'];
            }

            $uploadDir = $this->bannerUploadDir();
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = $allowed[$mime];
            $fileName = 'banner_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

            $destPath = $uploadDir . $fileName;

            if (!move_uploaded_file($img['tmp_name'], $destPath)) {
                return ['ok' => false, 'message' => 'Failed to upload image.'];
            }

            $image_path = 'uploads/banners/' . $fileName;

            $params = [$title, $subtitle, $button_text, $button_link, $image_path, $sort_order, $is_active];

            $ok = $this->model->create($params);

            if (!$ok) {
                @unlink($destPath);
                return ['ok' => false, 'message' => 'Database insert failed.'];
            }

            return ['ok' => true, 'message' => 'Banner created successfully.', 'image_path' => $image_path];
        }

    }



    function edit()
    {
        $this->sessionCheck();
        $banner = $this->model->getBanner($_GET['id']);
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/banners/edit.php';
        include BASE_PATH . 'views/include/footer.php';
    }


    function updateBanner($post, $files): array
    {
        $this->sessionCheck();
        $id = $post['id'] ?? '';
        $title = trim($post['title'] ?? '');
        $subtitle = trim($post['subtitle'] ?? '');
        $button_text = trim($post['button_text'] ?? '');
        $button_link = trim($post['button_link'] ?? '');
        $sort_order = $post['sort_order'] ?? '';
        $is_active = $post['is_active'] ?? '1';

        if (!ctype_digit((string) $id) || (int) $id < 1) {
            setFlash('danger', 'Invalid banner ID.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }
        $id = (int) $id;

        // Required validation
        if ($title === '' || $subtitle === '' || $button_text === '' || $button_link === '') {
            setFlash('danger', 'All fields are required.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }

        if (!filter_var($button_link, FILTER_VALIDATE_URL)) {
            setFlash('danger', 'Please enter a valid button link URL.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }

        if (!ctype_digit((string) $sort_order) || (int) $sort_order < 1) {
            setFlash('danger', 'Sort order must be a positive number.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }
        $sort_order = (int) $sort_order;

        if (!in_array((string) $is_active, ['0', '1'], true)) {
            setFlash('danger', 'Invalid status value.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }
        $is_active = (int) $is_active;

        
        $old = $this->model->getBanner($id);
        if (!$old) {
            setFlash('danger', 'Banner not found.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }

        $newImagePath = $old['image_path'] ?? '';
        $uploadedNewImage = false;
        $destPath = '';

        
        if (isset($files['image_path']) && $files['image_path']['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($files['image_path']['error'] !== UPLOAD_ERR_OK) {
                setFlash('danger', 'Image upload error.');
                header('Location: index.php?controller=banners&function=edit&id='.$id);
                exit;
            }

            $img = $files['image_path'];

            if ($img['size'] > 2 * 1024 * 1024) {
                setFlash('danger', 'Image size must be less than 2MB.');
                header('Location: index.php?controller=banners&function=edit&id='.$id);
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
                setFlash('danger', 'Only JPG, PNG, or WEBP images are allowed.');
                header('Location: index.php?controller=banners&function=edit&id='.$id);
                exit;
            }

            $uploadDir = $this->bannerUploadDir();
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = $allowed[$mime];
            $fileName = 'banner_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

            $destPath = $uploadDir . $fileName;

            if (!move_uploaded_file($img['tmp_name'], $destPath)) {
                setFlash('danger', 'Failed to upload image.');
                header('Location: index.php?controller=banners&function=edit&id='.$id);
                exit;
            }

            $newImagePath = 'uploads/banners/' . $fileName;
            $uploadedNewImage = true;
        }

        $params = [$title, $subtitle, $button_text, $button_link, $newImagePath, $sort_order, $is_active, $id];

        $ok = $this->model->updateBannerModel( $params);

        if (!$ok) {
            if ($uploadedNewImage && $destPath) {
                @unlink($destPath);
            }
            setFlash('danger', 'Database update failed.');
            header('Location: index.php?controller=banners&function=edit&id='.$id);
            exit;
        }

        if ($uploadedNewImage && !empty($old['image_path'])) {

            $diskPath = BASE_PATH.$old['image_path'];
            if (is_file($diskPath)) {
                @unlink($diskPath);
            }
        }

        setFlash('success', 'Banner updated successfully.');
        header('Location: index.php?controller=banners&function=view');
        exit;
    }



    function deleteBanner()
    {
        $this->sessionCheck();

        if (isset($_GET['id'])) {
            $id = (int) filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        }
        if ($id < 1) {
            setFlash('danger', 'Invalid banner ID.');
            header('Location: index.php?controller=banners&function=view');
            exit;
        }

        $row = $this->model->getBanner($id);

        if (!$row) {
            setFlash('danger', 'Banner not found.');
            header('Location: index.php?controller=banners&function=view');
            exit;
        }

        $ok = $this->model->deleteBanner($id);

        if (!$ok) {
            setFlash('danger', 'Database delete failed.');
            header('Location: index.php?controller=banners&function=view');
            exit;
        }

        if (!empty($row['image_path'])) {
            $diskPath = BASE_PATH.$row['image_path'];
            if (is_file($diskPath)) {
                @unlink($diskPath);
            }
        }

        setFlash('success', 'Banner deleted successfully.');
        header('Location: index.php?controller=banners&function=view');
        exit;
    }













    public function bannerUploadDir()
    {
        return BASE_PATH . 'uploads/banners/';
    }


    function logout()
    {
        $this->sessionCheck();
        include('views/include/header.php');
        include('views/include/navbar.php');
        include('views/logout.php');
        include('views/include/footer.php');
    }
}