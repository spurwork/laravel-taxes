<?php

namespace Appleton\Taxes\Countries\US\Indiana;

use Appleton\Taxes\Classes\BaseLocalIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Indiana\IndianaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class IndianaLocalIncome extends BaseLocalIncome
{
    private const COUNTIES = [
        'Adams' => AdamsIncome::class,
        'Allen' => AllenIncome::class,
        'Bartholomew' => BartholomewIncome::class,
        'Benton' => BentonIncome::class,
        'Blackford' => BlackfordIncome::class,
        'Boone' => BooneIncome::class,
        'Brown' => BrownIncome::class,
        'Carroll' => CarrollIncome::class,
        'Cass' => CassIncome::class,
        'Clark' => ClarkIncome::class,
        'Clay' => ClayIncome::class,
        'Clinton' => ClintonIncome::class,
        'Crawford' => CrawfordIncome::class,
        'Daviess' => DaviessIncome::class,
        'Dearborn' => DearbornIncome::class,
        'Decatur' => DecaturIncome::class,
        'DeKalb' => DeKalbIncome::class,
        'Delaware' => DelawareIncome::class,
        'Dubois' => DuboisIncome::class,
        'Elkhart' => ElkhartIncome::class,
        'Fayette' => FayetteIncome::class,
        'Floyd' => FloydIncome::class,
        'Fountain' => FountainIncome::class,
        'Franklin' => FranklinIncome::class,
        'Fulton' => FultonIncome::class,
        'Gibson' => GibsonIncome::class,
        'Grant' => GrantIncome::class,
        'Greene' => GreeneIncome::class,
        'Hamilton' => HamiltonIncome::class,
        'Hancock' => HancockIncome::class,
        'Harrison' => HarrisonIncome::class,
        'Hendricks' => HendricksIncome::class,
        'Henry' => HenryIncome::class,
        'Howard' => HowardIncome::class,
        'Huntington' => HuntingtonIncome::class,
        'Jackson' => JacksonIncome::class,
        'Jasper' => JasperIncome::class,
        'Jay' => JayIncome::class,
        'Jefferson' => JeffersonIncome::class,
        'Jennings' => JenningsIncome::class,
        'Johnson' => JohnsonIncome::class,
        'Knox' => KnoxIncome::class,
        'Kosciusko' => KosciuskoIncome::class,
        'LaGrange' => LaGrangeIncome::class,
        'Lake' => LakeIncome::class,
        'LaPorte' => LaPorteIncome::class,
        'Lawrence' => LawrenceIncome::class,
        'Madison' => MadisonIncome::class,
        'Marion' => MarionIncome::class,
        'Marshall' => MarshallIncome::class,
        'Martin' => MartinIncome::class,
        'Miami' => MiamiIncome::class,
        'Monroe' => MonroeIncome::class,
        'Montgomery' => MontgomeryIncome::class,
        'Morgan' => MorganIncome::class,
        'Newton' => NewtonIncome::class,
        'Noble' => NobleIncome::class,
        'Ohio' => OhioIncome::class,
        'Orange' => OrangeIncome::class,
        'Owen' => OwenIncome::class,
        'Parke' => ParkeIncome::class,
        'Perry' => PerryIncome::class,
        'Pike' => PikeIncome::class,
        'Porter' => PorterIncome::class,
        'Posey' => PoseyIncome::class,
        'Pulaski' => PulaskiIncome::class,
        'Putnam' => PutnamIncome::class,
        'Randolph' => RandolphIncome::class,
        'Ripley' => RipleyIncome::class,
        'Rush' => RushIncome::class,
        'Scott' => ScottIncome::class,
        'Shelby' => ShelbyIncome::class,
        'Spencer' => SpencerIncome::class,
        'St. Joseph' => StJosephIncome::class,
        'Starke' => StarkeIncome::class,
        'Steuben' => SteubenIncome::class,
        'Sullivan' => SullivanIncome::class,
        'Switzerland' => SwitzerlandIncome::class,
        'Tippecanoe' => TippecanoeIncome::class,
        'Tipton' => TiptonIncome::class,
        'Union' => UnionIncome::class,
        'Vanderburgh' => VanderburghIncome::class,
        'Vermillion' => VermillionIncome::class,
        'Vigo' => VigoIncome::class,
        'Wabash' => WabashIncome::class,
        'Warren' => WarrenIncome::class,
        'Warrick' => WarrickIncome::class,
        'Washington' => WashingtonIncome::class,
        'Wayne' => WayneIncome::class,
        'Wells' => WellsIncome::class,
        'White' => WhiteIncome::class,
        'Whitley' => WhitleyIncome::class,
    ];

    public const SUPPLEMENTAL_TAX_RATE = 0.0323;

    private const PERSONAL_EXEMPTION_AMOUNTS = 1000;
    private const DEPENDENT_EXEMPTION_AMOUNT = 1500;

    protected $tax_information;

    public function __construct(IndianaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getTaxBrackets(): array
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    public function compute(Collection $tax_areas)
    {
        if (array_key_exists($this->tax_information->county_of_residence, self::COUNTIES)) {
            //
        } elseif (array_key_exists($this->tax_information->county_of_employment, self::COUNTIES)) {
            //
        }
    }

    public function getAdjustedEarnings()
    {
        $personal_allowances = self::PERSONAL_EXEMPTION_AMOUNTS * $this->tax_information->personal_exemptions;
        $dependent_allowances = self::DEPENDENT_EXEMPTION_AMOUNT * $this->tax_information->dependent_exemptions;

        $exemptions = ($personal_allowances + $dependent_allowances) / $this->payroll->pay_periods;
        return ($this->payroll->getEarnings() - $exemptions) * $this->payroll->pay_periods;
    }

    abstract public function getTaxRate(): float;
}
