<?php

namespace Kirillsimin\Semaphore;

class VersionedRoute
{
    public static $IlluminateRoute = \Route::class;

    protected $path;
    protected $restMethod;
    protected $controllerName;
    protected $methodName;

    public function __construct($restMethod, $path, $action)
    {
        $this->parseAction($action);
        $this->restMethod = $restMethod;
        $this->path = $path;
    }

    private function register()
    {
        $restMethod = $this->restMethod;
        return self::$IlluminateRoute::$restMethod($this->path, $this->getAction());
    }

    private function getAction()
    {
        $controllerFileName = last(explode('\\', $this->controllerName));
        $action = $this->controllerName  . '\\' . $controllerFileName . $this->getVersionSuffix();
        if (!empty($this->methodName)) {
            $action .= '@' . $this->methodName;
        }

        return $action;
    }

    private function getVersion()
    {
        return request()->header('controller-version') ?? 0;
    }

    private function getVersionSuffix()
    {
        return  "_v".$this->getVersion();
    }

    private function parseAction($action)
    {
        $array = explode('@', $action);

        $this->controllerName = $array[0];
        if (count($array) > 1) {
            $this->methodName = $array[1];
        }
    }

    private static function build($restMethod, $path, $action)
    {
        $instance = new static($restMethod, $path, $action);
        return $instance->register();
    }

    public static function __callStatic($name, $arguments)
    {
        list($path, $action) = $arguments;
        return self::build($name, $path, $action);
    }

    public static function fake()
    {
        return self::$IlluminateRoute = \Mockery::mock('VersionedRouteIlluminateFake');
    }

    public static function restoreFake()
    {
        return self::$IlluminateRoute = \Route::class;
    }
}
