<?php
session_start();

class adminController
{
    public $model; 

    function __construct()
    {
        include_once('model/admin.php');
        $this->model = new adminModel();
        
    }

    function sessionCheck()
    {
        if (!isset($_SESSION["is_login"])) {
            header('location: index.php?controller=admin&function=login');
        }
    }
    function login()
    {
        include('views/include/header.php');
        include('views/login.php');
        include('views/include/footer.php');
    }


    public function adminLogin($email, $password){
        $result = $this->model->getAdminUser($email);
        if ($result && password_verify($password, $result['password_hash'])) {
            $_SESSION["is_login"] = true;
            $_SESSION["admin"] = $result;

            setFlash('success', 'congratulations Login successful');
            header('Location: index.php?controller=admin&function=home');
            exit;
        }else{
            setFlash('danger', 'Invalid email or password.');
            header('Location: index.php?controller=admin&function=login');
            exit;
        }
    }

    function home(){
        $this->sessionCheck();
        $totalCars = $this->model->getAllCarsCount();
        $totalBanners = $this->model->getAllBannersCount();
        $cars = $this->model->getAllCars();
        include('views/include/header.php');
        include('views/include/navbar.php');
        include('views/home.php');
        include('views/include/footer.php');
    }













    function logout(){
        $this->sessionCheck();
        include('views/include/header.php');
        include('views/include/navbar.php');
        include('views/logout.php');
        include('views/include/footer.php');
    }
}