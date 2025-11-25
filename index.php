<?php
// Auto setup database on first access
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

// Jika koneksi gagal, redirect ke setup
if (!$conn) {
    header('Location: setup.php');
    exit;
}

// Lanjutkan dengan aplikasi lain
// test 
require_once 'models/UserModel.php';
require_once 'controllers/CrudController.php';

$controller = new CrudController();
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'list':
    default:
        $controller->list();
        break;
    
}
?>
