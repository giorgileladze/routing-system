<?php

namespace api\core\routingSystem;

class Router extends RoutingService
{
    private string $uri;
    private string $request_method;

    private array $route;

    public function __construct ( string $uri, string $request_method ) {
        $this->uri = $uri;
        $this->request_method = $request_method;
    }

    public function get_starter_method () {
        $routes = $this->initialize_routes();

        $route = $this->get_requested_route($routes, $this->uri, $this->request_method);

        $this->route = $route;
    }

    public function call_starter_method () {
        list($class, $method) = explode("::", $this->route["method"]);

        $params = self::bind_dinamyc_uri_params($this->route["uri"], $this->uri);

        $instance = new $class();

        return call_user_func_array([$instance, $method], $params);
    }

}