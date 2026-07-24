<?php

class Router {
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void {
        $this->addRoute('GET', $path, $controller, $method);
    }

    public function post(string $path, string $controller, string $method): void {
        $this->addRoute('POST', $path, $controller, $method);
    }

    private function addRoute(string $httpMethod, string $path, string $controller, string $method): void {
        $this->routes[$httpMethod][$path] = [
            'controller' => $controller,
            'method'     => $method
        ];
    }

    public function dispatch(string $httpMethod, string $requestUri): void {
        // Nettoyer l'URI 
        $path = parse_url($requestUri, PHP_URL_PATH);
        $path = rtrim($path, '/') ?: '/';

        foreach ($this->routes[$httpMethod] ?? [] as $routePath => $route) {
            // Convertir les paramètres {id} en regex
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
            $pattern = '#^' . $pattern . '$#';
        
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Supprimer le premier élément qui est la correspondance complète
                $controllerName = $route['controller'];
                $methodName = $route['method'];

                $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

                if (!file_exists($controllerFile)) {
                    http_response_code(404);
                    echo "Fichier du contrôleur '$controllerName' non trouvé.";
                    return;
                }

                require_once $controllerFile;
                $controller = new $controllerName();
                $controller->$methodName(...$matches);
                return;
            }
        }
        // Aucune route correspondante trouvée
        $this->abort(404, "Page non trouvée");
    }

    private function abort(int $code, string $message): void {
        http_response_code($code);
        $viewFile = __DIR__ . '/../../views/errors/' . $code . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "Erreur $code" . ($message ? " : $message" : '');
        }
        exit;
    }
}