<?php
session_start();

class site_settingsController
{
    public $model;


    function __construct()
    {
        include_once BASE_PATH . 'model/site_settings.php';
        $this->model = new site_settingsModel();

    }

    function sessionCheck()
    {
        if (!isset($_SESSION["is_login"])) {
            header('location: index.php?controller=admin&function=login');
        }
    }

    public function edit()
    {
        $this->sessionCheck();

        $settings = $this->model->get();
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/site_settings/edit.php';
        include BASE_PATH . 'views/include/footer.php';
    }


    public function createSettings($post, $files)
    {
        $this->sessionCheck();
        $site_name = trim($post['site_name'] ?? '');
        $header_phone = trim($post['header_phone'] ?? '');
        $header_email = trim($post['header_email'] ?? '');

        if ($site_name === '' || $header_phone === '' || $header_email === '') {
            setFlash('danger', 'All fields are required.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        if (!filter_var($header_email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Please enter a valid email address.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        // Logo required on create
        if (!isset($files['logo_path']) || $files['logo_path']['error'] !== UPLOAD_ERR_OK) {
            setFlash('danger', 'Logo is required.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        $logo = $this->handleLogoUpload($files['logo_path']);
        if (!$logo['ok']) {
            setFlash('danger', $logo['message']);
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        // If row already exists, create should not insert again; redirect to update
        $existing = $this->model->get();
        if ($existing) {
            setFlash('warning', 'Settings already exist. Please update instead.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        $ok = $this->model->create([$site_name, $logo['path'], $header_phone, $header_email]);

        if (!$ok) {
            @unlink($logo['disk_path']);
            setFlash('danger', 'Database insert failed.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        setFlash('success', 'Settings saved successfully.');
        header('Location: index.php?controller=site_settings&function=edit');
        exit;
    }

    public function updateSettings($post, $files)
    {
        $this->sessionCheck();
        $site_name = trim($post['site_name'] ?? '');
        $header_phone = trim($post['header_phone'] ?? '');
        $header_email = trim($post['header_email'] ?? '');

        if ($site_name === '' || $header_phone === '' || $header_email === '') {
            setFlash('danger', 'All fields are required.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        if (!filter_var($header_email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Please enter a valid email address.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        $existing = $this->model->get();
        if (!$existing) {
            setFlash('warning', 'Settings not found. Please create first.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        $logo_path = $existing['logo_path'] ?? '';
        $newUploaded = null;

        // Logo optional on update
        if (isset($files['logo_path']) && $files['logo_path']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($files['logo_path']['error'] !== UPLOAD_ERR_OK) {
                setFlash('danger', 'Logo upload error.');
                header('Location: index.php?controller=site_settings&function=edit');
                exit;
            }

            $upload = $this->handleLogoUpload($files['logo_path']);
            if (!$upload['ok']) {
                setFlash('danger', $upload['message']);
                header('Location: index.php?controller=site_settings&function=edit');
                exit;
            }

            $logo_path = $upload['path'];
            $newUploaded = $upload;
        }

        $ok = $this->model->update([$site_name, $logo_path, $header_phone, $header_email]);

        if (!$ok) {
            // rollback new file if DB update fails
            if ($newUploaded) {
                @unlink($newUploaded['disk_path']);
            }
            setFlash('danger', 'Database update failed.');
            header('Location: index.php?controller=site_settings&function=edit');
            exit;
        }

        // if logo changed, delete old logo file
        if ($newUploaded && !empty($existing['logo_path'])) {
            $oldDisk = BASE_PATH.$existing['logo_path'];
            if (is_file($oldDisk)) {
                @unlink($oldDisk);
            }
        }

        setFlash('success', 'Settings updated successfully.');
        header('Location: index.php?controller=site_settings&function=edit');
        exit;
    }



    private function handleLogoUpload($file)
    {
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['ok' => false, 'message' => 'Logo must be less than 2MB.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            return ['ok' => false, 'message' => 'Only JPG, PNG, or WEBP images allowed.'];
        }

        $uploadDir = $this->settingsUploadDir();
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'logo_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mime];
        $diskPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $diskPath)) {
            return ['ok' => false, 'message' => 'Failed to upload logo.'];
        }

        // Store relative path in DB
        $relativePath = 'uploads/site-settings/' . $fileName;

        return [
            'ok' => true,
            'path' => $relativePath,
            'disk_path' => $diskPath
        ];
    }




    public function settingsUploadDir(){
        return BASE_PATH . 'uploads/site-settings/';
    }








}