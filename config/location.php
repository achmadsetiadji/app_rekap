<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | The default driver you would like to use for location retrieval.
    |
    */
    'driver' => \Stevebauman\Location\Drivers\IpApi::class,

    /*
    |--------------------------------------------------------------------------
    | Driver Fallbacks
    |--------------------------------------------------------------------------
    |
    | The drivers you want to use to retrieve the users location
    | if the above selected driver is unavailable.
    |
    */
    'fallbacks' => [
        \Stevebauman\Location\Drivers\IpApi::class,
        \Stevebauman\Location\Drivers\GeoPlugin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Location
    |--------------------------------------------------------------------------
    |
    | The database location is used when storing a users location. By default
    | this is inside the downloaded maxmind database.
    |
    */
    'database_path' => database_path('maxmind/GeoLite2-City.mmdb'),

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | The latitude and longitude to return when the environment is testing.
    |
    */
    'testing' => [
        'enabled' => env('LOCATION_TESTING', false),
        'ip' => '66.102.0.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | The cache settings for location requests.
    |
    */
    'cache' => [
        'enabled' => env('LOCATION_CACHE', true),
        'duration' => 3600, // seconds
    ],
];