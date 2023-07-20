<?php
    class Controller {
        function runAction($actionName) {
            $actionName .= "Action";
            
            if (method_exists($this, $actionName)) {
                header('Content-Type: text/html; charset=utf-8');
                $this->$actionName();
            }else {
                include 'views/status-pages/404.html';
            }
        }
        protected function render($view, $params = []) {
            $viewFile = 'views/' . $view;
            if (file_exists($viewFile)) {
                if (get_called_class() == "LoginController") {
                    include_once $viewFile;
                }else {
                    extract($params);
                    ob_start();
                    include $viewFile;
                    $content = ob_get_clean();
                    include_once 'views/layouts/default.php';
                }
            } else {
                include 'views/status-pages/404.html';
            }
        }
        
    }

?>
