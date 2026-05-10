<?php
/**
 * Routeur tres simple base sur les parametres GET ?controller=xxx&action=yyy
 * Charge dynamiquement le controleur et appelle la methode demandee.
 */
class Router
{
    public function dispatch()
    {
        $controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'home';
        $actionName     = isset($_GET['action'])     ? $_GET['action']     : 'index';

        // Securite : on filtre les caracteres pour eviter les inclusions externes
        $controllerName = preg_replace('/[^a-zA-Z0-9_]/', '', $controllerName);
        $actionName     = preg_replace('/[^a-zA-Z0-9_]/', '', $actionName);

        $className = ucfirst($controllerName) . 'Controller';
        $file      = __DIR__ . '/../controllers/' . $className . '.php';

        if (!file_exists($file)) {
            $this->error404("Controleur introuvable : $className");
            return;
        }

        require_once $file;

        if (!class_exists($className)) {
            $this->error404("Classe introuvable : $className");
            return;
        }

        $controller = new $className();

        if (!method_exists($controller, $actionName)) {
            $this->error404("Action introuvable : $actionName");
            return;
        }

        $controller->$actionName();
    }

    private function error404($msg = '')
    {
        http_response_code(404);
        require_once __DIR__ . '/Controller.php';
        $c = new class extends Controller {
            public function show($msg) { $this->render('errors/404', ['message' => $msg]); }
        };
        $c->show($msg);
    }
}
