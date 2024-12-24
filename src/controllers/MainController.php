<?php

class MainController
{

    public function home(): void
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $this->render('home', ['basePath' => $basePath]);
    }



    public function about(): void
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $this->render('about', ['basePath' => $basePath]);
    }



    public function notFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found!";
    }


    private function render($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once __DIR__ . '/../views/partials/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../views/partials/footer.php';
        } else {
            echo "View not found: $view";
        }
    }

}
