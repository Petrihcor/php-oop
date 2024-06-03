<?php

namespace App\Kernel\Router;

use App\Kernel\Auth\Auth;
use App\Kernel\Controller\Controller;
use App\Kernel\Database\Database;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\Request;
use App\Kernel\Middleware\AbstractMiddleware;
use App\Kernel\Session\Session;
use App\Kernel\Storage\Storage;
use App\Kernel\View\View;
//use App\Kernel\Middleware\AuthMiddleware;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST'=> []
    ];



    public function __construct(
        private View $view,
        private Request $request,
        private Redirect $redirect,
        private Session $session,
        private Database $database,
        private Auth $auth,
        private Storage $storage
    ) {
        $this->initRoutes();
    }

    public function handleRequest(string $uri, string $method): void {
        $route = $this->findRoute($uri, $method);

        if (!$route) {
            $this->notFound();
            exit;
        }

        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware){

                $middleware = new $middleware($this->request, $this->auth, $this->redirect);
                $middleware->handle();
            }
        }

        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();
            /**
             * @var Controller $controller
             */
            $controller = new $controller();

            call_user_func([$controller, 'setView'], $this->view);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func([$controller, 'setStorage'], $this->storage);

            call_user_func([$controller, $action]);
        } else {
            call_user_func($route->getAction());
        }


//        $routes = $this->getRoutes();
//
//        $routes[$uri]();


//        if (array_key_exists($uri, $routes)) {
//            require $_SERVER['DOCUMENT_ROOT'] . "/src/controllers/{$routes[$uri]}";
//        } else {
//            http_response_code(404);
//            require $_SERVER['DOCUMENT_ROOT'] . '/src/views/errors/404.tpl.php';
//            die;
//        }
    }

    private function notFound(): void {
        echo '404 | not found';
    }

    private function findRoute(string $uri, string $method): Route|false {
        if (!isset($this->routes[$method][$uri])){
            return false;
        }
        return $this->routes[$method][$uri];
    }

    private function initRoutes() {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }

    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array {
        return require $_SERVER['DOCUMENT_ROOT'] . "/config/routes.php";
    }
}