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

    'user' => \Illuminate\Foundation\Auth\User::class,

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

            'alabama' => [

                'alabama_income_tax_information' => env('TAXES_ALABAMA_INCOME_TAX_INFORMATION', 'alabama_income_tax_information'),

            ],

            'georgia' => [
                'georgia_income_tax_information' => env('TAXES_GEORGIA_INCOME_TAX_INFORMATION', 'georgia_income_tax_information'),
            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Rates
    |--------------------------------------------------------------------------
    |
    | Specify the rate to be used for taxes here or in the env.
    |
    */

    'rates' => [

        'us' => [

            'alabama' => [

                'unemployment' => env('TAXES_ALABAMA_UNEMPLOYMENT_TAX_RATE', 0.027),

            ],

            'georgia' => [

                'unemployment' => env('TAXES_GEORGIA_UNEMPLOYMENT_TAX_RATE', 0.027),

            ],

        ],

    ],

];
