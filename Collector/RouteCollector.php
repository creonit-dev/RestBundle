<?php


namespace Creonit\RestBundle\Collector;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class RouteCollector implements CollectorInterface
{
    /** @var RouterInterface */
    protected $router;

    /** @var Route[]|null */
    protected $routes;

    protected $pathPatterns = [];

    public function __construct(ContainerInterface $container)
    {
        $this->router = $container->get('router');
        $this->pathPatterns = $container->getParameter('creonit_rest.path_patterns');
    }

    /**
     * @return Route[]|null
     */
    public function collect()
    {
        if (null === $this->routes) {
            $this->routes = $this->collectRoutes();
        }

        return $this->routes;
    }

    /**
     * @return Route[]
     */
    protected function collectRoutes()
    {
        $result = [];

        foreach ($this->router->getRouteCollection()->all() as $route) {
            if (!$route->hasDefault('_controller')) {
                continue;
            }

            if ($this->mathPath($route)) {
                $result[] = $route;
            }
        }

        return $result;
    }

    protected function mathPath(Route $route)
    {
        foreach ($this->pathPatterns as $pattern) {
            if (preg_match('{' . $pattern . '}', $route->getPath())) {
                return true;
            }
        }

        return 0 === count($this->pathPatterns);
    }
}