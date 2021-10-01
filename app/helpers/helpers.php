<?php

/**
 * Inertia helper.
 *
 * @param null|string                                   $component
 * @param array|\Illuminate\Contracts\Support\Arrayable $props
 *
 * @return \Inertia\ResponseFactory|\Inertia\Response
 */
function inertiaPro($component = null, $props = [], $url = null) // My update

{
    $instance = \Inertia\Inertia::getFacadeRoot();

    if ($component) {
        return $instance->render($component, $props, $url); // My update
    }

    return $instance;
}
/**
 * banner helper.
 *
 * @param type null|string
 * @param message null|string
 * @return void
 */
function banner($type = 'seccess', $message = '') // My update

{
    request()->session()->flash("flash", []);
    $id = rand(100, 999);
    $flash = [
        'id' => $id,
        'banner' => $message,
        'bannerStyle' => $type,
        'user' => auth()->user()->only(['id', 'name', 'profile_photo_url']),
    ];
    request()->session()->flash("flash.$id", $flash);
}
