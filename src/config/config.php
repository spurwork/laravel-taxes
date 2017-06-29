<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model Class
    |--------------------------------------------------------------------------
    |
    | Specify the full path to your User model.
    |
    */

    'user' => '',

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    |
    | Specify the names to be used for database tables here or in the env.
    |
    */

    'tables' => [

        'governmental_unit_areas' => env('TAXES_GOVERNMENTAL_UNIT_AREAS', 'governmental_unit_areas'),

        'tax_areas' => env('TAXES_TAX_AREAS', 'tax_areas'),

        'tax_information' => env('TAXES_TAX_INFORMATION', 'tax_information'),
        
        'us' => [

            'federal_income_tax_information' => env('TAXES_FEDERAL_INCOME_TAX_INFORMATION', 'federal_income_tax_information'),

        ],


    ],

];
