<?php

namespace App\Inertia;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\App;
use Inertia\ResponseFactory as InertiaResponseFactory;

class ResponseFactory extends InertiaResponseFactory
{
    public function render($component, $props = [], $backToUrl = null) // My update

    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        return new Response(
            $component,
            array_merge($this->sharedProps, $props),
            $this->rootView,
            $this->getVersion(),
            // My update
            $backToUrl
        );
    }
}
