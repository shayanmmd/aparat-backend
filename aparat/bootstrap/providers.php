<?php

use App\Providers\InjectServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\InjectServiceProvider::class,
    InjectServiceProvider::class,
];
