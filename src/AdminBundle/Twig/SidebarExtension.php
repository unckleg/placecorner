<?php

namespace AdminBundle\Twig;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class SidebarExtension extends \Twig_Extension
{
    const PARENT = 'parent';
    const CHILD  = 'child';

    /**
     * Current route catched from RequestStack _route
     * @var string
     */
    protected $currentRoute;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * SidebarExtension constructor.
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        if (!empty($request->getCurrentRequest())) {
            $this->requestStack = $request;
            $this->currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        }
    }

    /**
     * Returns final class to be attached in sidebar div, If not active returns empty string
     * @param  string $resource
     * @param  string $type  | Parent or Child
     * @return string $class
     */
    public function isActive($resource, $type)
    {
        $resource = (string) $resource;
        $type     = strtolower(!isset($type) ? self::PARENT : $type);

        if ($type !== self::PARENT && $type !== self::CHILD) {
            throw new Exception('Second parameter can be defined just type of string and with value: parent or child');
        }

        if ($resource == $this->currentRoute) {
            if ($type == self::PARENT) {
                $class = ' active open';
            } elseif ($type == self::CHILD) {
                $class = ' active';
            }

            return $class;
        }
            return '';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isActive', array($this, 'isActive')),
        );
    }
}