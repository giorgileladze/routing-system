<?php

namespace api\core\routingSystem;

use Symfony\Component\Yaml\Yaml;
use ReflectionClass;

abstract class RoutingService
{
    private string $searching_root = "../modules/*";

    public function initialize_routes () : array {
        $routes = [];

        foreach (glob($this->searching_root, GLOB_ONLYDIR) as $moduleDir){
            $file = $moduleDir . "/routes.yml";
            $fileContent = Yaml::parseFile($file);

            $base_uri = $fileContent["module"]["base_uri"];

            foreach ($fileContent["module"]["services"] as $route){
                $route["uri"] = $base_uri . $route["uri"];
                if(substr($route["uri"], -1) === "/") $route["uri"] = substr($route["uri"], 0, -1);

                if(key_exists($route["uri"], $routes)) {
                    header("HTTP/1.0 500");
                    exit("Each route should be unic");
                };

                if(!array_key_exists("method", $route)) {
                    header("HTTP/1.0 500");
                    exit("Missing starter method");
                }
                $routes[$route["uri"]] = $route;
            }
        }

        return $routes;
    }

    public function get_requested_route (array $routes, string $request_uri, string $method) : array {
        $request_uri = explode("/", $request_uri);

        foreach ($routes as $route) {
            $registered_uri = $route["uri"];

            $registered_uri = explode("/", $registered_uri);

            if(count($request_uri) != count($registered_uri)) continue;

            $bool = true;
            for($i = 0; $i < count($registered_uri); $i++){
                if(
                    !strpbrk($registered_uri[$i], "{}")
                    && $registered_uri[$i] != $request_uri[$i]
                ) $bool = false;
            }

//            if($bool && $route["request_method"] != $method) {
//                header("HTTP/1.0 500");
//                exit("Invalid request method");
//            } else if ($bool) return $route;
            if ($bool) return $route;
        }

        header("HTTP/1.0 404");
        exit("Not found");
    }

    public function bind_dinamyc_uri_params ($uri, $dynamic_uri) : array {
        $arguments = [];

        $uriArr = explode("/", $uri);
        $dynamic_uriArr = explode("/", $dynamic_uri);

        foreach ($uriArr as $i => $component) {
            if(strpbrk($component, "{}")) $arguments[] = $dynamic_uriArr[$i];
        }

        return $arguments;
    }
}