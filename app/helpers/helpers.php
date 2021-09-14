<?php

/**
 * Inertia helper.
 *
 * @param null|string                                   $component
 * @param array|\Illuminate\Contracts\Support\Arrayable $props
 *
 * @return \Inertia\ResponseFactory|\Inertia\Response
 */
function inertiaPro($component = null, $props = [], $url = null)
{
    $instance = \Inertia\Inertia::getFacadeRoot();

    if ($component) {
        return $instance->render($component, $props, $url);
    }

    return $instance;
}