<?php
session_start();

class footer_settingsController
{
    public $model;


    function __construct()
    {
        include_once BASE_PATH . 'model/footer_settings.php';
        $this->model = new footer_settingsModel();
    

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

        $footer = $this->model->get();
        include BASE_PATH . 'views/include/header.php';
        include BASE_PATH . 'views/include/navbar.php';
        include BASE_PATH . 'views/site_settings/footer.php';
        include BASE_PATH . 'views/include/footer.php';
    }



    public function createFooterSettings($post)
    {
        $this->sessionCheck();
        $about_text = trim($post['about_text'] ?? '');
        $address    = trim($post['address'] ?? '');
        $phone      = trim($post['phone'] ?? '');
        $email      = trim($post['email'] ?? '');
        $facebook   = trim($post['facebook'] ?? '');
        $instagram  = trim($post['instagram'] ?? '');
        $youtube    = trim($post['youtube'] ?? '');

        // Required checks
        if ($about_text === '' || $address === '' || $phone === '' || $email === '') {
            setFlash('danger', 'About text, address, phone and email are required.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Please enter a valid email address.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        // Optional URL checks
        foreach (['facebook' => $facebook, 'instagram' => $instagram, 'youtube' => $youtube] as $key => $url) {
            if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
                setFlash('danger', ucfirst($key) . ' must be a valid URL.');
                header('Location: index.php?controller=footer_settings&function=edit');
                exit;
            }
        }

        // If already exists, prevent duplicate insert
        if ($this->model->get()) {
            setFlash('warning', 'Footer settings already exist. Please update instead.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        $ok = $this->model->create([$about_text, $address, $phone, $email, $facebook, $instagram, $youtube]);

        if (!$ok) {
            setFlash('danger', 'Database insert failed.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        setFlash('success', 'Footer settings saved successfully.');
        header('Location: index.php?controller=footer_settings&function=edit');
        exit;
    }

    public function updateFooterSettings($post)
    {
        $this->sessionCheck();
        $about_text = trim($post['about_text'] ?? '');
        $address    = trim($post['address'] ?? '');
        $phone      = trim($post['phone'] ?? '');
        $email      = trim($post['email'] ?? '');
        $facebook   = trim($post['facebook'] ?? '');
        $instagram  = trim($post['instagram'] ?? '');
        $youtube    = trim($post['youtube'] ?? '');

        if ($about_text === '' || $address === '' || $phone === '' || $email === '') {
            setFlash('danger', 'About text, address, phone and email are required.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('danger', 'Please enter a valid email address.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        foreach (['facebook' => $facebook, 'instagram' => $instagram, 'youtube' => $youtube] as $key => $url) {
            if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
                setFlash('danger', ucfirst($key) . ' must be a valid URL.');
                header('Location: index.php?controller=footer_settings&function=edit');
                exit;
            }
        }

        if (!$this->model->get()) {
            setFlash('warning', 'Footer settings not found. Please create first.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        $ok = $this->model->update([$about_text, $address, $phone, $email, $facebook, $instagram, $youtube]);

        if (!$ok) {
            setFlash('danger', 'Database update failed.');
            header('Location: index.php?controller=footer_settings&function=edit');
            exit;
        }

        setFlash('success', 'Footer settings updated successfully.');
        header('Location: index.php?controller=footer_settings&function=edit');
        exit;
    }
}