<?php
namespace App\Controllers;

class Controller {
    protected function view($name, $data = []) {
        extract($data);
        $viewPath = dirname(__DIR__) . "/views/{$name}.php";
        
        if (file_exists($viewPath)) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            require dirname(__DIR__) . "/views/layouts/main.php";
        } else {
            throw new \Exception("View {$name} not found");
        }
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getPost($key = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    protected function getQuery($key = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }
} 