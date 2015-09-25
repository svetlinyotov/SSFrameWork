<?php

/**
 * This file may not be redistributed in whole or significant part.
 * ------------------ THIS IS NOT FREE SOFTWARE -------------------
 *
 * Copyright 2015 All Rights Reserved
 *
 * The default app router
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      Routes/Route.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame\Routers;

class Route implements \SSFrame\Routers\RouterInterface {

    private static $rawRoutes = [];
    private $routesTree = null;
    private static $allowedMethods = ['get', 'post', 'put', 'any'];
    public $controller = null;
    public $method = null;
    public $params = array();

    /**
     * Add new route to list of available routes
     *
     * @param $method
     * @param $route
     * @param $action
     * @throws \Exception
     */
    public static function addRoute($method, $route, $action)
    {
        $method = (array)$method;
        if (array_diff($method, self::$allowedMethods)) {
            throw new \Exception('Method:' . $method . ' is not valid');
        }
        if (array_search('any', $method) !== false) {
            $methods = ['get' => $action, 'post' => $action, 'put' => $action];
        } else {
            foreach ($method as $v) {
                $methods[$v] = $action;
            }
        }
        self::$rawRoutes[] = ['route' => $route, 'method' => $methods];
    }

    /**
     * Get routes tree structure. Can be cashed and later loaded using load() method
     * @return array|null
     */
    public function dump()
    {
        if ($this->routesTree == null) {
            $this->routesTree = $this->parseRoutes(self::$rawRoutes);
        }
        return $this->routesTree;
    }
    /**
     * Find route in route tree structure.
     *
     * @param $method
     * @return array
     * @throws \Exception
     */
    public function getURI($method = null) {
        $uri = "/".substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1)."/";

        if ($this->routesTree == null) {
            $this->routesTree = $this->parseRoutes(self::$rawRoutes);
        }
        $search = $this->normalize($uri);
        $node = $this->routesTree;
        $params = [];

        //loop every segment in request url, compare it, collect parameters names and values
        foreach ($search as $v) {
            if (isset($node[$v['use']])) {
                $node = $node[$v['use']];
            } elseif (isset($node['*'])) {
                $node = $node['*'];
                $params[$node['name']] = $v['name'];
            } elseif (isset($node['?'])) {
                $node = $node['?'];
                $params[$node['name']] = $v['name'];
            } else {
                throw new \Exception('Route for uri: ' . $uri . ' was not found');
            }
        }
        //check for route with optional parameters that are not in request url until valid action is found
        while (!isset($node['exec']) && isset($node['?'])) {
            $node = $node['?'];
        }
        if (isset($node['exec'])) {
            if (!isset($node['exec']['method'][$method]) && !isset($node['exec']['method']['any'])) {
                throw new \Exception('Method: ' . $method . ' is not allowed for this route');
            }
            $this->controller = str_replace('Controller', '', explode("@", $node['exec']['method'][$method])[0]);
            $this->method = explode("@", $node['exec']['method'][$method])[1];
            $this->params = $params;
            return [
                'route' => $node['exec']['route'],
                'method' => $method,
                'action' => $node['exec']['method'][$method],
                'params' => $params];
        }
        throw new \Exception('Route for uri: ' . $uri . ' was not found');
    }
    /**
     * Load routes tree structure that was taken from dump() method
     * This method will overwrite anny previously added routes.
     * @param array $arr
     */
    public function load(array $arr)
    {
        $this->routesTree = $arr;
    }
    /**
     * Normalize route structure and extract dynamic and optional parts
     *
     * @param $route
     * @return array
     */
    protected function normalize($route)
    {
        //make sure that all urls have the same structure
        if (mb_substr($route, 0, 1) != '/') {
            $route = '/' . $route;
        }
        if (mb_substr($route, -1, 1) == '/') {
            $route = substr($route, 0, -1);
        }
        $result = explode('/', $route);
        $result[0] = '/';
        $ret = [];
        //check for dynamic and optional parameters
        foreach ($result as $v) {
            if (!$v) {
                continue;
            }
            if (strpos($v, '?}') !== false) {
                $ret[] = ['name' => explode('?}', mb_substr($v, 1))[0], 'use' => '?'];
            } elseif (strpos($v, '}') !== false) {
                $ret[] = ['name' => explode('}', mb_substr($v, 1))[0], 'use' => '*'];
            } else {
                $ret[] = ['name' => $v, 'use' => $v];
            }
        }
        return $ret;
    }
    /**
     * Build tree structure from all routes.
     *
     * @param $routes
     * @return array
     */
    protected function parseRoutes($routes)
    {
        $tree = [];
        foreach ($routes as $route) {
            $node = &$tree;
            foreach ($this->normalize($route['route']) as $segment) {
                if (!isset($node[$segment['use']])) {
                    $node[$segment['use']] = ['name' => $segment['name']];
                }
                $node = &$node[$segment['use']];
            }
            //node exec can exists only if a route is already added.
            //This happens when a route is added more than once with different methods.
            if (isset($node['exec'])) {
                $node['exec']['method'] = array_merge($node['exec']['method'], $route['method']);
            } else {
                $node['exec'] = $route;
            }
            $node['name'] = $segment['name'];
        }
        return $tree;
    }

    public static function match($method, $uri, $action){
        return self::addRoute($method, $uri, $action);
    }
}