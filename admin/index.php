<?php 
$controller = 'admin';
$function = 'login';
define('BASE_URL', 'http://localhost/carsdekho/admin/');
define('BASE_PATH', __DIR__ . '/'); // points to admin/


function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,   // this can pass class -  success | danger | warning | info
        'message' => $message
    ];
}

function getFlash(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}


if (isset($_GET['controller']) && $_GET['controller'] != '' ) {
	$controller = $_GET['controller'];
}
if (isset($_GET['function']) && $_GET['function'] != '' ) {
	$function = $_GET['function'];
}

if (file_exists('controller/'.$controller.'.php')) {
	include('controller/'.$controller.'.php');
	$class = $controller.'Controller';
	$obj = new $class();
	if(method_exists($class, $function)){
		$obj->$function();
	}else{
		echo "Page Not found";
	}
	
}else{
	echo 'Page not found';
}

?>
