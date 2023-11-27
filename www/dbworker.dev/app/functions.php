<?php

    function routeMatcher(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path   = $_SERVER['REQUEST_URI'];

        $routs = require_once 'app/routs.php';


        foreach ($routs[$method] as $key => $route) {
            if (preg_match('#^'.$key.'$#', $path, $matches)) {
                array_shift($matches);
                [$controller, $action] = explode('::', $route);

                return [$controller, $action, $matches];
            }
        }

        [$controller, $action] = explode('::', $routs['_ERROR']['_error']);

        return [$controller, $action, null];
    }

    function request($key = null, $value = null)
    {
        $request = $_REQUEST;

        if (empty($request)) {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method === 'PATCH' || $method === 'DELETE'
                || $method === 'POST'
                || $method === 'PUT'
            ) {
                $jsonData = json_decode(file_get_contents('php://input'), true);
                if ($jsonData) {
                    $request = array_merge($request, $jsonData);
                }
            }
        }
        if ($key && $value) {
//            $request[$key] = $value;
            $_REQUEST[$key] = $value;
            return null;
        } elseif ($key) {
            return $request[$key] ?? null;
        }

        return $request;
    }

    function viewJson($data, $code = 200)
    {

        return ['json', json_encode($data), $code];
    }
    function view($template, $data, $code = 200)
    {
        $content = file_get_contents(__DIR__.'/v/'.$template);
        return ['html', $content, $code];
    }

    function send($response)
    {
        [$type, $content, $code] = $response;

        if ($type === 'redirect') {
            header("Location:$content");

            return;
        }

        if ($type === 'json') {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code($code);
        }
        if ($type === 'error') {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code($code);
        }
        echo $content;
    }

    function redirect($url)
    {
        return ['redirect', $url];
    }