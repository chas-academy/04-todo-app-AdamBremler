<?php

use Todo\Utils\JsonHandler;

function getUri()
{
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    return $uri;
}

function getMethod()
{
    parse_str(file_get_contents('php://input'), $result);
    
    if (isset($result['_METHOD'])) {
        $method = $result['_METHOD'];
    } else {
        $method = $_SERVER['REQUEST_METHOD'];
    }

    return $method;
}

function filter_body()
{
    parse_str(file_get_contents('php://input'), $data);
    return $data;
}

function includeWith($filePath, $variables = array())
{
    $viewPath = '../src/Views' . $filePath;
    $output = null;

    if (file_exists($viewPath)) {
        // Extract the variables to a local namespace
        extract($variables);

        // Start output buffering
        ob_start();

        // Include the template file
        include $viewPath;

        // End buffering and return its contents
        $output = ob_get_clean();
    } else {
        throw new NotFoundException("Couldn't find the view or partial");
    }

    return $output;
}

