<?php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


        $basePath = '/ABS-ISTA';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        // Ensure URI starts with a leading slash
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes[$method] as $route => $action) {
            $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match

             
                // Handle POST request parameters
                if ($method === 'POST') {
                    $params = $_POST;
                    $matches = array_merge($matches, array_values($params)); // Use array values to avoid named parameters
                }

                if (is_callable($action)) {
                    call_user_func_array($action, $matches);
                } elseif (is_array($action)) {
                    $controller = new $action[0]();
                    call_user_func_array([$controller, $action[1]], $matches);
                } else {
                    echo "Error: Invalid route action.";
                }
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found: Route not found.";
    }
}
