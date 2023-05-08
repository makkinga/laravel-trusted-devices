<?php

return [
    # Overwrite the auto detection of the guard
    'guard'              => null,

    # The layout to use for the views
    'layout'             => 'layouts.app',

    # The middleware to use for the routes
    'middleware'         => ['web', 'auth'],

    # Automatically trust the first device
    'trust_first_device' => true,
];
