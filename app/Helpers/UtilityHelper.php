<?php

if (!function_exists('is_active')) {
    function is_active($patterns): bool
    {
        foreach ((array) $patterns as $pattern) {
            if (str_contains($pattern, '/')) { // cocokkan dengan URI
                if (request()->is($pattern)) {
                    return true;
                }
            } else { // cocokkan dengan route name
                if (request()->routeIs($pattern)) {
                    return true;
                }
            }
        }
        return false;
    }
}