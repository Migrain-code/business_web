<?php

namespace App\Core;

use Illuminate\Routing\ResourceRegistrar as OriginalRegistrar;

class CustomResourceRegistrar extends OriginalRegistrar
{
    // add data to the array
    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['datatable', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];


    /**
     * Add the data method for a resourceful route.
     *
     * @param string $name
     * @param string $base
     * @param string $controller
     * @param array $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDatatable($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name . '/datatable');

        $action = $this->getResourceAction($name, $controller, 'datatable', $options);

        return $this->router->get($uri, $action);
    }
}
