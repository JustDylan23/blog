<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteActiveExtension extends AbstractExtension
{
    public function __construct(
        private RequestStack $requestStack
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('route_active', [$this, 'routeActive']),
        ];
    }

    public function routeActive($route, array $params = []): string
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request !== null
            && $route === $request->attributes->get('_route')
            && count(array_diff_assoc($request->attributes->get('_route_params'), $params)) === 0
        ) {
            return 'active';
        }
        return '';
    }
}
