<?php

namespace Infrastructure\Shared\Service;

use Symfony\Component\Routing\RouterInterface;

final readonly class RouteExtractor
{
    public function __construct(
        private RouterInterface $router
    ) {}

    public function getAllRoutes(): array
    {
        $routes = [];
        foreach ($this->router->getRouteCollection() as $name => $route) {
            // Filtrer les routes système ou internes si nécessaire
            if (str_starts_with($name, '_')) {
                continue;
            }
            $routes[$name] = [
                'name' => $name,
                'path' => $route->getPath(),
                'methods' => $route->getMethods()
            ];
        }
        return $routes;
    }
}
