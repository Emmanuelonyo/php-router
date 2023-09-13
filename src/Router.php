<?php
declare(strict_types=1);

namespace Emmanuelonyo\PhpRouter;

use Emmanuelonyo\PhpRouter\Http\Request;
use Emmanuelonyo\PhpRouter\Http\Response;

class Router
{
    private array $handler;
    private  $notFoundHandler;
    private const METHOD_POST = "POST";
    private const METHOD_GET = "GET";
    private const METHOD_PUT = "PUT";
    private const METHOD_DELETE = "DELETE";
    private const METHOD_UPDATE = "UPDATE";
    private const METHOD_PATCH = "PATCH";
    

    public function get(string $path, $handler): void
    {
        $this->makeHandler(self::METHOD_GET, $path, $handler);
    }

    public function post(string $path, $handler): void{
        $this->makeHandler(self::METHOD_POST, $path, $handler);
    }

    public function delete(string $path, $handler){
        $this->makeHandler(self::METHOD_DELETE, $path, $handler);
    }

    public function update(string $path, $handler){
        $this->makeHandler(self::METHOD_UPDATE, $path, $handler);
    }

    public function patch(string $path, $handler){
        $this->makeHandler(self::METHOD_PATCH, $path, $handler);
    }

    public function put(string $path, $handler){
        $this->makeHandler(self::METHOD_PUT, $path, $handler);
    }

    private function makeHandler(string $method, string $path, $handler): void
    {
        // Replace placeholders in the path with a regular expression
        $pathRegex = preg_replace('/:([a-z]+)/', '(?P<$1>[^/]+)', $path);
    
        $this->handler[$method . $pathRegex] = [
            'path' => $path,
            'pathRegex' => $pathRegex,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function makeNotfoundHandler($handler): void
    {
        $this->notFoundHandler = $handler;
    }


    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        $params = [];
        foreach ($this->handler as $handler) {
            if ($method === $handler['method']) {
                $matches = [];
                if (preg_match('#^' . $handler['pathRegex'] . '$#', $requestPath, $matches)) {
                    // Replace named groups with captured values
                    $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
                    $callback = $handler['handler'];
                    break;
                }
            }
        }
    
        if (is_string($callback)) {
            $parts = explode('::', $callback);
    
            if (is_array($parts)) {
                $className = array_shift($parts);
                $handler = new $className;
    
                $method = array_shift($parts);
                $callback = [$handler, $method];
            }
        }
    
        if (!$callback) {
            header("HTTP/1.0 404 Not Found");
            if (!empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
            }
        }
        $req = new Request;
        $res = new Response;
        call_user_func_array($callback, [$params, $req, $res]);
    }

}