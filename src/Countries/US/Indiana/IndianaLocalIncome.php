<?php

namespace Appleton\Taxes\Countries\US\Indiana;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Indiana\AdamsIncome\AdamsIncome;
use Appleton\Taxes\Countries\US\Indiana\AllenIncome\AllenIncome;
use Appleton\Taxes\Countries\US\Indiana\BartholomewIncome\BartholomewIncome;
use Appleton\Taxes\Countries\US\Indiana\BentonIncome\BentonIncome;
use Appleton\Taxes\Countries\US\Indiana\BlackfordIncome\BlackfordIncome;
use Appleton\Taxes\Countries\US\Indiana\BooneIncome\BooneIncome;
use Appleton\Taxes\Countries\US\Indiana\BrownIncome\BrownIncome;
use Appleton\Taxes\Countries\US\Indiana\CarrollIncome\CarrollIncome;
use Appleton\Taxes\Countries\US\Indiana\CassIncome\CassIncome;
use Appleton\Taxes\Countries\US\Indiana\ClarkIncome\ClarkIncome;
use Appleton\Taxes\Countries\US\Indiana\ClayIncome\ClayIncome;
use Appleton\Taxes\Countries\US\Indiana\ClintonIncome\ClintonIncome;
use Appleton\Taxes\Countries\US\Indiana\CrawfordIncome\CrawfordIncome;
use Appleton\Taxes\Countries\US\Indiana\DaviessIncome\DaviessIncome;
use Appleton\Taxes\Countries\US\Indiana\DearbornIncome\DearbornIncome;
use Appleton\Taxes\Countries\US\Indiana\DecaturIncome\DecaturIncome;
use Appleton\Taxes\Countries\US\Indiana\DeKalbIncome\DeKalbIncome;
use Appleton\Taxes\Countries\US\Indiana\DelawareIncome\DelawareIncome;
use Appleton\Taxes\Countries\US\Indiana\DuboisIncome\DuboisIncome;
use Appleton\Taxes\Countries\US\Indiana\ElkhartIncome\ElkhartIncome;
use Appleton\Taxes\Countries\US\Indiana\FayetteIncome\FayetteIncome;
use Appleton\Taxes\Countries\US\Indiana\FloydIncome\FloydIncome;
use Appleton\Taxes\Countries\US\Indiana\FountainIncome\FountainIncome;
use Appleton\Taxes\Countries\US\Indiana\FranklinIncome\FranklinIncome;
use Appleton\Taxes\Countries\US\Indiana\FultonIncome\FultonIncome;
use Appleton\Taxes\Countries\US\Indiana\GibsonIncome\GibsonIncome;
use Appleton\Taxes\Countries\US\Indiana\GrantIncome\GrantIncome;
use Appleton\Taxes\Countries\US\Indiana\GreeneIncome\GreeneIncome;
use Appleton\Taxes\Countries\US\Indiana\HamiltonIncome\HamiltonIncome;
use Appleton\Taxes\Countries\US\Indiana\HancockIncome\HancockIncome;
use Appleton\Taxes\Countries\US\Indiana\HarrisonIncome\HarrisonIncome;
use Appleton\Taxes\Countries\US\Indiana\HendricksIncome\HendricksIncome;
use Appleton\Taxes\Countries\US\Indiana\HenryIncome\HenryIncome;
use Appleton\Taxes\Countries\US\Indiana\HowardIncome\HowardIncome;
use Appleton\Taxes\Countries\US\Indiana\HuntingtonIncome\HuntingtonIncome;
use Appleton\Taxes\Countries\US\Indiana\JacksonIncome\JacksonIncome;
use Appleton\Taxes\Countries\US\Indiana\JasperIncome\JasperIncome;
use Appleton\Taxes\Countries\US\Indiana\JayIncome\JayIncome;
use Appleton\Taxes\Countries\US\Indiana\JeffersonIncome\JeffersonIncome;
use Appleton\Taxes\Countries\US\Indiana\JenningsIncome\JenningsIncome;
use Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\JohnsonIncome;
use Appleton\Taxes\Countries\US\Indiana\KnoxIncome\KnoxIncome;
use Appleton\Taxes\Countries\US\Indiana\KosciuskoIncome\KosciuskoIncome;
use Appleton\Taxes\Countries\US\Indiana\LaGrangeIncome\LaGrangeIncome;
use Appleton\Taxes\Countries\US\Indiana\LakeIncome\LakeIncome;
use Appleton\Taxes\Countries\US\Indiana\LaPorteIncome\LaPorteIncome;
use Appleton\Taxes\Countries\US\Indiana\LawrenceIncome\LawrenceIncome;
use Appleton\Taxes\Countries\US\Indiana\MadisonIncome\MadisonIncome;
use Appleton\Taxes\Countries\US\Indiana\MarionIncome\MarionIncome;
use Appleton\Taxes\Countries\US\Indiana\MarshallIncome\MarshallIncome;
use Appleton\Taxes\Countries\US\Indiana\MartinIncome\MartinIncome;
use Appleton\Taxes\Countries\US\Indiana\MiamiIncome\MiamiIncome;
use Appleton\Taxes\Countries\US\Indiana\MonroeIncome\MonroeIncome;
use Appleton\Taxes\Countries\US\Indiana\MontgomeryIncome\MontgomeryIncome;
use Appleton\Taxes\Countries\US\Indiana\MorganIncome\MorganIncome;
use Appleton\Taxes\Countries\US\Indiana\NewtonIncome\NewtonIncome;
use Appleton\Taxes\Countries\US\Indiana\NobleIncome\NobleIncome;
use Appleton\Taxes\Countries\US\Indiana\OhioIncome\OhioIncome;
use Appleton\Taxes\Countries\US\Indiana\OrangeIncome\OrangeIncome;
use Appleton\Taxes\Countries\US\Indiana\OwenIncome\OwenIncome;
use Appleton\Taxes\Countries\US\Indiana\ParkeIncome\ParkeIncome;
use Appleton\Taxes\Countries\US\Indiana\PerryIncome\PerryIncome;
use Appleton\Taxes\Countries\US\Indiana\PikeIncome\PikeIncome;
use Appleton\Taxes\Countries\US\Indiana\PorterIncome\PorterIncome;
use Appleton\Taxes\Countries\US\Indiana\PoseyIncome\PoseyIncome;
use Appleton\Taxes\Countries\US\Indiana\PulaskiIncome\PulaskiIncome;
use Appleton\Taxes\Countries\US\Indiana\PutnamIncome\PutnamIncome;
use Appleton\Taxes\Countries\US\Indiana\RandolphIncome\RandolphIncome;
use Appleton\Taxes\Countries\US\Indiana\RipleyIncome\RipleyIncome;
use Appleton\Taxes\Countries\US\Indiana\RushIncome\RushIncome;
use Appleton\Taxes\Countries\US\Indiana\ScottIncome\ScottIncome;
use Appleton\Taxes\Countries\US\Indiana\ShelbyIncome\ShelbyIncome;
use Appleton\Taxes\Countries\US\Indiana\SpencerIncome\SpencerIncome;
use Appleton\Taxes\Countries\US\Indiana\StarkeIncome\StarkeIncome;
use Appleton\Taxes\Countries\US\Indiana\SteubenIncome\SteubenIncome;
use Appleton\Taxes\Countries\US\Indiana\StJosephIncome\StJosephIncome;
use Appleton\Taxes\Countries\US\Indiana\SullivanIncome\SullivanIncome;
use Appleton\Taxes\Countries\US\Indiana\SwitzerlandIncome\SwitzerlandIncome;
use Appleton\Taxes\Countries\US\Indiana\TippecanoeIncome\TippecanoeIncome;
use Appleton\Taxes\Countries\US\Indiana\TiptonIncome\TiptonIncome;
use Appleton\Taxes\Countries\US\Indiana\UnionIncome\UnionIncome;
use Appleton\Taxes\Countries\US\Indiana\VanderburghIncome\VanderburghIncome;
use Appleton\Taxes\Countries\US\Indiana\VermillionIncome\VermillionIncome;
use Appleton\Taxes\Countries\US\Indiana\VigoIncome\VigoIncome;
use Appleton\Taxes\Countries\US\Indiana\WabashIncome\WabashIncome;
use Appleton\Taxes\Countries\US\Indiana\WarrenIncome\WarrenIncome;
use Appleton\Taxes\Countries\US\Indiana\WarrickIncome\WarrickIncome;
use Appleton\Taxes\Countries\US\Indiana\WashingtonIncome\WashingtonIncome;
use Appleton\Taxes\Countries\US\Indiana\WayneIncome\WayneIncome;
use Appleton\Taxes\Countries\US\Indiana\WellsIncome\WellsIncome;
use Appleton\Taxes\Countries\US\Indiana\WhiteIncome\WhiteIncome;
use Appleton\Taxes\Countries\US\Indiana\WhitleyIncome\WhitleyIncome;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class IndianaLocalIncome extends BaseLocalIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0323;

    public const COUNTY_CODES = [
        1 => AdamsIncome::class,
        2 => AllenIncome::class,
        3 => BartholomewIncome::class,
        4 => BentonIncome::class,
        5 => BlackfordIncome::class,
        6 => BooneIncome::class,
        7 => BrownIncome::class,
        8 => CarrollIncome::class,
        9 => CassIncome::class,
        10 => ClarkIncome::class,
        11 => ClayIncome::class,
        12 => ClintonIncome::class,
        13 => CrawfordIncome::class,
        14 => DaviessIncome::class,
        15 => DearbornIncome::class,
        16 => DecaturIncome::class,
        17 => DeKalbIncome::class,
        18 => DelawareIncome::class,
        19 => DuboisIncome::class,
        20 => ElkhartIncome::class,
        21 => FayetteIncome::class,
        22 => FloydIncome::class,
        23 => FountainIncome::class,
        24 => FranklinIncome::class,
        25 => FultonIncome::class,
        26 => GibsonIncome::class,
        27 => GrantIncome::class,
        28 => GreeneIncome::class,
        29 => HamiltonIncome::class,
        30 => HancockIncome::class,
        31 => HarrisonIncome::class,
        32 => HendricksIncome::class,
        33 => HenryIncome::class,
        34 => HowardIncome::class,
        35 => HuntingtonIncome::class,
        36 => JacksonIncome::class,
        37 => JasperIncome::class,
        38 => JayIncome::class,
        39 => JeffersonIncome::class,
        40 => JenningsIncome::class,
        41 => JohnsonIncome::class,
        42 => KnoxIncome::class,
        43 => KosciuskoIncome::class,
        44 => LaGrangeIncome::class,
        45 => LakeIncome::class,
        46 => LaPorteIncome::class,
        47 => LawrenceIncome::class,
        48 => MadisonIncome::class,
        49 => MarionIncome::class,
        50 => MarshallIncome::class,
        51 => MartinIncome::class,
        52 => MiamiIncome::class,
        53 => MonroeIncome::class,
        54 => MontgomeryIncome::class,
        55 => MorganIncome::class,
        56 => NewtonIncome::class,
        57 => NobleIncome::class,
        58 => OhioIncome::class,
        59 => OrangeIncome::class,
        60 => OwenIncome::class,
        61 => ParkeIncome::class,
        62 => PerryIncome::class,
        63 => PikeIncome::class,
        64 => PorterIncome::class,
        65 => PoseyIncome::class,
        66 => PulaskiIncome::class,
        67 => PutnamIncome::class,
        68 => RandolphIncome::class,
        69 => RipleyIncome::class,
        70 => RushIncome::class,
        71 => StJosephIncome::class,
        72 => ScottIncome::class,
        73 => ShelbyIncome::class,
        74 => SpencerIncome::class,
        75 => StarkeIncome::class,
        76 => SteubenIncome::class,
        77 => SullivanIncome::class,
        78 => SwitzerlandIncome::class,
        79 => TippecanoeIncome::class,
        80 => TiptonIncome::class,
        81 => UnionIncome::class,
        82 => VanderburghIncome::class,
        83 => VermillionIncome::class,
        84 => VigoIncome::class,
        85 => WabashIncome::class,
        86 => WarrenIncome::class,
        87 => WarrickIncome::class,
        88 => WashingtonIncome::class,
        89 => WayneIncome::class,
        90 => WellsIncome::class,
        91 => WhiteIncome::class,
        92 => WhitleyIncome::class,
    ];

    private const PERSONAL_EXEMPTION_AMOUNTS = 1000;
    private const DEPENDENT_EXEMPTION_AMOUNT = 1500;

    protected $tax_information;
    protected $is_resident;

    public function __construct(IndianaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets(): array
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    public function getAdjustedEarnings()
    {
        $personal_allowances = self::PERSONAL_EXEMPTION_AMOUNTS * $this->tax_information->personal_exemptions;
        $dependent_allowances = self::DEPENDENT_EXEMPTION_AMOUNT * $this->tax_information->dependent_exemptions;

        $exemptions = ($personal_allowances + $dependent_allowances) / $this->payroll->pay_periods;
        return ($this->payroll->getEarnings() - $exemptions) * $this->payroll->pay_periods;
    }

    abstract public function getTaxRate(): float;

    public function compute(Collection $tax_areas)
    {
        if (array_key_exists($this->tax_information->county_lived, static::COUNTY_CODES)) {
            $local_tax_class = static::COUNTY_CODES[$this->tax_information->county_lived];
            $this->is_resident = true;
        } elseif (array_key_exists($this->tax_information->county_worked, static::COUNTY_CODES)) {
            $local_tax_class = static::COUNTY_CODES[$this->tax_information->county_worked];
            $this->resident = false;
        }

        if (!is_subclass_of(get_called_class(), $local_tax_class)) {
            return 0;
        }

        return parent::compute($tax_areas);
    }
}
