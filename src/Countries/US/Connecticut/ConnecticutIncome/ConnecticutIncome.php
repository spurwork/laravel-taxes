<?php

namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;

abstract class ConnecticutIncome extends BaseStateIncome
{
    public const WITHHOLDING_CODE_A = 'A';
    public const WITHHOLDING_CODE_B = 'B';
    public const WITHHOLDING_CODE_C = 'C';
    public const WITHHOLDING_CODE_D = 'D';
    public const WITHHOLDING_CODE_E = 'E';
    public const WITHHOLDING_CODE_F = 'F';

    const FILING_STATUSES = [
        self::WITHHOLDING_CODE_A => 'A',
        self::WITHHOLDING_CODE_B => 'B',
        self::WITHHOLDING_CODE_C => 'C',
        self::WITHHOLDING_CODE_D => 'D',
        self::WITHHOLDING_CODE_E => 'E',
        self::WITHHOLDING_CODE_F => 'F',
    ];

    const PERSONAL_EXEMPTION = [
        self::WITHHOLDING_CODE_A => [
            'base' => 24000,
            'amount' => 12000,
            'floor' => 0,
            'modifier' => [
                'amount' => 1000,
                'per' => 1000,
            ],
        ],
        self::WITHHOLDING_CODE_B => [
            'base' => 38000,
            'amount' => 19000,
            'floor' => 0,
            'modifier' => [
                'amount' => 1000,
                'per' => 1000,
            ]
        ],
        self::WITHHOLDING_CODE_C => [
            'base' => 48000,
            'amount' => 24000,
            'floor' => 0,
            'modifier' => [
                'amount' => 1000,
                'per' => 1000,
            ]
        ],
        self::WITHHOLDING_CODE_F => [
            'base' => 30000,
            'amount' => 15000,
            'floor' => 0,
            'modifier' => [
                'amount' => 1000,
                'per' => 1000,
            ]
        ],
    ];

    const ANNUAL_GROSS_TAX_AMOUNT = [
        self::WITHHOLDING_CODE_A => [
            [0, 0.03, 0],
            [10000, 0.05, 300],
            [50000, 0.055, 2300],
            [100000, 0.06, 5050],
            [200000, 0.065, 11050],
            [250000, 0.069, 14300],
            [500000, 0.0699, 31550],
        ],
        self::WITHHOLDING_CODE_B => [
            [0, 0.03, 0],
            [16000, 0.05, 480],
            [80000, 0.055, 3680],
            [160000, 0.06, 8080],
            [320000, 0.065, 17680],
            [400000, 0.069, 22880],
            [800000, 0.0699, 50480],
        ],
        self::WITHHOLDING_CODE_C => [
            [0, 0.03, 0],
            [20000, 0.05, 600],
            [100000, 0.055, 4600],
            [200000, 0.06, 10100],
            [400000, 0.065, 22100],
            [500000, 0.069, 28600],
            [1000000, 0.0699, 63100],
        ],
        self::WITHHOLDING_CODE_D => [
            [0, 0.03, 0],
            [10000, 0.05, 300],
            [50000, 0.055, 2300],
            [100000, 0.06, 5050],
            [200000, 0.065, 11050],
            [250000, 0.069, 14300],
            [500000, 0.0699, 31550],
        ],
        self::WITHHOLDING_CODE_F => [
            [0, 0.03, 0],
            [10000, 0.05, 300],
            [50000, 0.055, 2300],
            [100000, 0.06, 5050],
            [200000, 0.065, 11050],
            [250000, 0.069, 14300],
            [500000, 0.0699, 31550],
        ],
    ];

    const PHASED_OUT = [
        self::WITHHOLDING_CODE_A => [
            [0, 0],
            [50250, 20],
            [52750, 40],
            [55250, 60],
            [57750, 80],
            [60250, 100],
            [62750, 120],
            [65250, 140],
            [67750, 160],
            [70250, 180],
            [72750, 200],
        ],
        self::WITHHOLDING_CODE_B => [
            [0, 0],
            [78500, 32],
            [82500, 64],
            [86500, 96],
            [90500, 128],
            [94500, 160],
            [98500, 192],
            [102500, 224],
            [106500, 256],
            [110500, 288],
            [114500, 320],
        ],
        self::WITHHOLDING_CODE_C => [
            [0, 0],
            [100500, 40],
            [105500, 80],
            [110500, 120],
            [115500, 160],
            [120500, 200],
            [125500, 240],
            [130500, 280],
            [135500, 320],
            [140500, 360],
            [145500, 400],
        ],
        self::WITHHOLDING_CODE_D => [
            [0, 0],
            [50250, 20],
            [52750, 40],
            [55250, 60],
            [57750, 80],
            [60250, 100],
            [62750, 120],
            [65250, 140],
            [67750, 160],
            [70250, 180],
            [72750, 200],
        ],
        self::WITHHOLDING_CODE_F => [
            [0, 0],
            [56500, 20],
            [61500, 40],
            [66500, 60],
            [71500, 80],
            [76500, 100],
            [81500, 120],
            [86500, 140],
            [91500, 160],
            [96500, 180],
            [101500, 200],
        ],
    ];

    const ADDITIONAL_RECAPTURE = [
        self::WITHHOLDING_CODE_A => [
            [0, 0],
            [200000, 90],
            [205000, 180],
            [210000, 270],
            [215000, 360],
            [220000, 450],
            [225000, 540],
            [230000, 630],
            [235000, 720],
            [240000, 810],
            [245000, 900],
            [250000, 990],
            [255000, 1080],
            [260000, 1170],
            [265000, 1260],
            [270000, 1350],
            [275000, 1440],
            [280000, 1530],
            [285000, 1620],
            [290000, 1710],
            [295000, 1800],
            [300000, 1890],
            [305000, 1980],
            [310000, 2070],
            [315000, 2160],
            [320000, 2250],
            [325000, 2340],
            [330000, 2430],
            [335000, 2520],
            [340000, 2610],
            [345000, 2700],
            [500000, 2750],
            [505000, 2800],
            [510000, 2850],
            [515000, 2900],
            [520000, 2950],
            [525000, 3000],
            [530000, 3050],
            [535000, 3100],
            [540000, 3150],
        ],
        self::WITHHOLDING_CODE_B => [
            [0, 0],
            [320000, 140],
            [328000, 280],
            [336000, 420],
            [344000, 560],
            [352000, 700],
            [360000, 840],
            [368000, 980],
            [376000, 1120],
            [384000, 1260],
            [392000, 1400],
            [400000, 1540],
            [408000, 1680],
            [416000, 1820],
            [424000, 1960],
            [432000, 2100],
            [440000, 2240],
            [448000, 2380],
            [456000, 2520],
            [464000, 2660],
            [472000, 2800],
            [480000, 2940],
            [488000, 3080],
            [496000, 3220],
            [504000, 3360],
            [512000, 3500],
            [520000, 3640],
            [528000, 3780],
            [536000, 3920],
            [544000, 4060],
            [552000, 4200],
            [800000, 4280],
            [808000, 4360],
            [816000, 4440],
            [824000, 4520],
            [832000, 4600],
            [840000, 4680],
            [848000, 4760],
            [856000, 4840],
            [864000, 4920],
        ],
        self::WITHHOLDING_CODE_C => [
            [0, 0],
            [400000, 180],
            [410000, 360],
            [420000, 540],
            [430000, 720],
            [440000, 900],
            [450000, 1080],
            [460000, 1260],
            [470000, 1440],
            [480000, 1620],
            [490000, 1800],
            [500000, 1980],
            [510000, 2160],
            [520000, 2340],
            [530000, 2520],
            [540000, 2700],
            [550000, 2880],
            [560000, 3060],
            [570000, 3240],
            [580000, 3420],
            [590000, 3600],
            [600000, 3780],
            [610000, 3960],
            [620000, 4140],
            [630000, 4320],
            [640000, 4500],
            [650000, 4680],
            [660000, 4860],
            [670000, 5040],
            [680000, 5220],
            [690000, 5400],
            [1000000, 5500],
            [1010000, 5600],
            [1020000, 5700],
            [1030000, 5800],
            [1040000, 5900],
            [1050000, 6000],
            [1060000, 6100],
            [1070000, 6200],
            [1080000, 6300],
        ],
        self::WITHHOLDING_CODE_D => [
            [0, 0],
            [200000, 90],
            [205000, 180],
            [210000, 270],
            [215000, 360],
            [220000, 450],
            [225000, 540],
            [230000, 630],
            [235000, 720],
            [240000, 810],
            [245000, 900],
            [250000, 990],
            [255000, 1080],
            [260000, 1170],
            [265000, 1260],
            [270000, 1350],
            [275000, 1440],
            [280000, 1530],
            [285000, 1620],
            [290000, 1710],
            [295000, 1800],
            [300000, 1890],
            [305000, 1980],
            [310000, 2070],
            [315000, 2160],
            [320000, 2250],
            [325000, 2340],
            [330000, 2430],
            [335000, 2520],
            [340000, 2610],
            [345000, 2700],
            [500000, 2750],
            [505000, 2800],
            [510000, 2850],
            [515000, 2900],
            [520000, 2950],
            [525000, 3000],
            [530000, 3050],
            [535000, 3100],
            [540000, 3150],
        ],
        self::WITHHOLDING_CODE_F => [
            [0, 0],
            [200000, 90],
            [205000, 180],
            [210000, 270],
            [215000, 360],
            [220000, 450],
            [225000, 540],
            [230000, 630],
            [235000, 720],
            [240000, 810],
            [245000, 900],
            [250000, 990],
            [255000, 1080],
            [260000, 1170],
            [265000, 1260],
            [270000, 1350],
            [275000, 1440],
            [280000, 1530],
            [285000, 1620],
            [290000, 1710],
            [295000, 1800],
            [300000, 1890],
            [305000, 1980],
            [310000, 2070],
            [315000, 2160],
            [320000, 2250],
            [325000, 2340],
            [330000, 2430],
            [335000, 2520],
            [340000, 2610],
            [345000, 2700],
            [500000, 2750],
            [505000, 2800],
            [510000, 2850],
            [515000, 2900],
            [520000, 2950],
            [525000, 3000],
            [530000, 3050],
            [535000, 3100],
            [540000, 3150],
        ],
    ];

    const ANNUAL_GROSS_MULTIPLICATION_PERCENTAGE = [
        self::WITHHOLDING_CODE_A => [
            [12000, .75],
            [15000, .70],
            [15500, .65],
            [16000, .60],
            [16500, .55],
            [17000, .50],
            [17500, .45],
            [18000, .40],
            [18500, .35],
            [20000, .30],
            [20500, .25],
            [21000, .20],
            [21500, .15],
            [25000, .14],
            [25500, .13],
            [26000, .12],
            [26500, .11],
            [27000, .10],
            [48000, .09],
            [48500, .08],
            [49000, .07],
            [49500, .06],
            [50000, .05],
            [50500, .04],
            [51000, .03],
            [51500, .02],
            [52000, .01],
            [52500, .00],
        ],
        self::WITHHOLDING_CODE_B => [
            [19000, .75],
            [24000, .70],
            [24500, .65],
            [25000, .60],
            [25500, .55],
            [26000, .50],
            [26500, .45],
            [27000, .40],
            [27500, .35],
            [34000, .30],
            [34500, .25],
            [35000, .20],
            [35500, .15],
            [44000, .14],
            [44500, .13],
            [45000, .12],
            [45500, .11],
            [46000, .10],
            [74000, .09],
            [74500, .08],
            [75000, .07],
            [75500, .06],
            [76000, .05],
            [76500, .04],
            [77000, .03],
            [77500, .02],
            [78000, .01],
            [78500, .00],
        ],
        self::WITHHOLDING_CODE_C => [
            [24000, .75],
            [30000, .70],
            [30500, .65],
            [31000, .60],
            [31500, .55],
            [32000, .50],
            [32500, .45],
            [33000, .40],
            [33500, .35],
            [40000, .30],
            [40500, .25],
            [41000, .20],
            [41500, .15],
            [50000, .14],
            [50500, .13],
            [51000, .12],
            [51500, .11],
            [52000, .10],
            [96000, .09],
            [96500, .08],
            [97000, .07],
            [97500, .06],
            [98000, .05],
            [98500, .04],
            [99000, .03],
            [99500, .02],
            [100000, .01],
            [100500, .00],
        ],
        self::WITHHOLDING_CODE_F => [
            [15000, .75],
            [18800, .70],
            [19300, .65],
            [19800, .60],
            [20300, .55],
            [20800, .50],
            [21300, .45],
            [21800, .40],
            [22300, .35],
            [25000, .30],
            [25500, .25],
            [26000, .20],
            [26500, .15],
            [31300, .14],
            [31800, .13],
            [32300, .12],
            [32800, .11],
            [33300, .10],
            [60000, .09],
            [60500, .08],
            [61000, .07],
            [61500, .06],
            [62000, .05],
            [62500, .04],
            [63000, .03],
            [63500, .02],
            [64000, .01],
            [64500, .00],
        ],
    ];

    public function __construct(ConnecticutIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }
}
