<?php
namespace App\Controllers;

class Controller{

    protected $viewPath;
    protected $template;

    public function __construct() {
        $this->viewPath = ROOT . '/app/Views/';
        $this->template = "default";
    }

    protected function render($view, $variables = []){
        ob_start();
        extract($variables);
        // $content = ob_get_clean();
        require($this->viewPath . str_replace('.', '/', $view) . '.php');
        $content = ob_get_clean();
        require($this->viewPath . 'templates/' . $this->template . '.php');
    }

    protected function forbidden(){
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }

    protected function notFound(){
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }

}