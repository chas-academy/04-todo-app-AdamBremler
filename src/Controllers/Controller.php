<?php

namespace Todo;

abstract class Controller
{
    protected function getScript($filename)
    {
        $file = strtolower($filename);
        return 'http://' . $_SERVER['HTTP_HOST'] . '/js/' . $file . '.js';
    }

    protected function getStylesheet($filename)
    {
        $file = strtolower($filename);
        return 'http://' . $_SERVER['HTTP_HOST'] . '/css/' . $file . '.css';
    }

    protected function view($view, $data = [])
    {

        $view = strtolower($view);
        $path = $_SERVER['DOCUMENT_ROOT'] . '/../src/Views/' . $view . '.view.php';
        $data = extract($data);

        if (file_exists($path)) {
            ob_start();

            include_once $_SERVER['DOCUMENT_ROOT'] . "/../src/Views/partials/head.php";

            include_once $path;

            include_once $_SERVER['DOCUMENT_ROOT'] . "/../src/Views/partials/footer.php";

            $renderedView = ob_get_contents();

            @ob_get_clean();

            echo $renderedView;

            return;
        } else {
            throw NotFoundException('View not found');
        }
    }

    public function redirect($url, $permanent = false) 
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: '.$url);
        exit();
    }
}
