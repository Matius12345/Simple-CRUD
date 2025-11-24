<?php
class CrudController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    public function list() {
        $stmt = $this->userModel->readAll();
        include 'views/header.php';
        include 'views/list.php';
        include 'views/footer.php';
    }

    public function create() {
        if($_POST) {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $telepon = $_POST['telepon'];
            $alamat = $_POST['alamat'];
            
            if($this->userModel->create($nama, $email, $telepon, $alamat)) {
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'>Gagal menambah data.</div>";
            }
        }
        
        include 'views/header.php';
        include 'views/create.php';
        include 'views/footer.php';
    }

    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID tidak ditemukan.');
        
        if($_POST) {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $telepon = $_POST['telepon'];
            $alamat = $_POST['alamat'];
            
            if($this->userModel->update($id, $nama, $email, $telepon, $alamat)) {
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate data.</div>";
            }
        }
        
        $user = $this->userModel->readOne($id);
        
        include 'views/header.php';
        include 'views/edit.php';
        include 'views/footer.php';
    }

    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID tidak ditemukan.');
        
        if($this->userModel->delete($id)) {
            header("Location: index.php");
        } else {
            die('Gagal menghapus data.');
        }
    }
}
?>