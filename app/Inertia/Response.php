<?php

namespace App\Inertia;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Inertia\Response as InertiaResponse;

class Response extends InertiaResponse implements Responsable
{
    protected $url;

    public function __construct($component, $props, $rootView = 'app', $version = null, $url = null) // My update

    {
        $this->component = $component;
        $this->props = $props instanceof Arrayable ? $props->toArray() : $props;
        $this->rootView = $rootView;
        $this->version = $version;
        // My update
        $this->url = $url;
    }

    public function toResponse($request)
    {
        $only = array_filter(explode(',', $request->header('X-Inertia-Partial-Data')));

        $props = ($only && $request->header('X-Inertia-Partial-Component') === $this->component)
        ? Arr::only($this->props, $only)
        : array_filter($this->props, function ($prop) {
            return !($prop instanceof LazyProp);
        });

        array_walk_recursive($props, function (&$prop) use ($request) {
            if ($prop instanceof LazyProp) {
                $prop = App::call($prop);
            }

            if ($prop instanceof Closure) {
                $prop = App::call($prop);
            }

            if ($prop instanceof Responsable) {
                $prop = $prop->toResponse($request)->getData();
            }

            if ($prop instanceof Arrayable) {
                $prop = $prop->toArray();
            }
        });

        foreach ($props as $key => $value) {
            if (str_contains($key, '.')) {
                data_set($props, $key, $value);
                unset($props[$key]);
            }
        }

        $page = [
            'component' => $this->component,
            'props' => $props,
            'url' => $this->url ? $this->url : $request->getRequestUri(),
            'version' => $this->version,
        ];

        if ($request->header('X-Inertia')) {
            return new JsonResponse($page, 200, [
                'Vary' => 'Accept',
                'X-Inertia' => 'true',
            ]);
        }

        return ResponseFactory::view($this->rootView, $this->viewData + ['page' => $page]);
    }
}
