<?php

namespace Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\GeoPoint;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\ReciprocalAgreement;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Classes\WorkerTaxes\TaxResult;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome as ParentGeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20180101\GeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\GeorgiaUnemployment;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\Medicare\MedicareEmployer;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\GovernmentalUnitArea;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\FederalTax1;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\LocalTax1;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateIncomeTax1;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateIncomeTax2;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateTax2;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateUnemploymentTax1;
use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateUnemploymentTax2;
use Appleton\Taxes\Tests\Unit\TestModelCreator;
use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use ReflectionClass;

/**
 * @property Taxes taxes
 */
class TaxesTest extends UnitTestCase
{
    use TestModelCreator;

    private $taxes;

    public function setUp(): void
    {
        parent::setUp();
        $this->taxes = app(Taxes::class);
    }

    public function testCalculate(): void
    {
        $home_location = new GeoPoint(0.0, 0.0);

        $area = $this->makeAreaAtPoint($home_location);
        $this->makeTaxArea(FederalTax1::class, $area);

        $wage = $this->makeWage($home_location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        /* @var TaxResult $federal_tax */
        $federal_tax = $tax_results->get(FederalTax1::class);
        self::assertThat(
            $federal_tax->getAmountInCents(),
            self::equalTo((10000) * FederalTax1::TAX_RATE)
        );
        self::assertThat($federal_tax->getEarningsInCents(), self::identicalTo(10000));
    }

    public function testCalculate_additional_taxes(): void
    {
        $home_location = new GeoPoint(0.0, 0.0);

        $area = $this->makeAreaAtPoint($home_location);
        $this->makeTaxArea(FederalTax1::class, $area);

        $this->makeTax(LocalTax1::class);

        $wage_1 = $this->makeWageWithAdditionalTax($home_location, LocalTax1::class);
        $wage_2 = $this->makeWage($home_location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            collect([$wage_1, $wage_2]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(2));

        /* @var TaxResult $federal_tax */
        $federal_tax = $tax_results->get(FederalTax1::class);
        self::assertThat(
            $federal_tax->getAmountInCents(),
            self::equalTo((10000 + 10000) * FederalTax1::TAX_RATE)
        );
        self::assertThat($federal_tax->getEarningsInCents(), self::identicalTo(10000 + 10000));

        /* @var TaxResult $local_tax */
        $local_tax = $tax_results->get(LocalTax1::class);
        self::assertThat(
            $local_tax->getAmountInCents(),
            self::equalTo(10000 * LocalTax1::TAX_RATE)
        );
        self::assertThat($local_tax->getEarningsInCents(), self::identicalTo(10000));
    }

    public function testCalculate_reciprocal_agreement(): void
    {
        $home_location = new GeoPoint(0.0, 0.0);
        $work_location = new GeoPoint(1.0, 1.0);

        $home_area_id = $this->makeAreaAtPoint($home_location);
        $this->makeTaxArea(StateIncomeTax1::class, $home_area_id);

        $work_area_id = $this->makeAreaAtPoint($work_location);
        $this->makeTaxArea(StateIncomeTax2::class, $work_area_id);

        $wage = $this->makeWage($work_location);

        $home_area = GovernmentalUnitArea::where('id', $home_area_id)->get()->first();
        $work_area = GovernmentalUnitArea::where('id', $work_area_id)->get()->first();
        $reciprocal_agreement = new ReciprocalAgreement($home_area->name, $work_area->name);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $home_location,
            $home_location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([$reciprocal_agreement]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        self::assertNull($tax_results->get(StateIncomeTax2::class));

        /* @var TaxResult $tax */
        $tax = $tax_results->get(StateIncomeTax1::class);
        self::assertThat(
            $tax->getAmountInCents(),
            self::equalTo(10000 * StateTax2::TAX_RATE)
        );
        self::assertThat($tax->getEarningsInCents(), self::identicalTo(10000));
    }

    public function testCalculate_state_income_added(): void
    {
        $location_with_state_income = new GeoPoint(0.0, 0.0);
        $location_without_state_income = new GeoPoint(1.0, 1.0);

        $area_id = $this->makeAreaAtPoint($location_with_state_income);
        $this->makeTaxArea(StateIncomeTax1::class, $area_id);

        $wage = $this->makeWage($location_without_state_income);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $location_with_state_income,
            $location_with_state_income,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        /* @var TaxResult $tax */
        $tax = $tax_results->get(StateIncomeTax1::class);
        self::assertThat(
            $tax->getAmountInCents(),
            self::equalTo(10000 * StateIncomeTax1::TAX_RATE)
        );
        self::assertThat($tax->getEarningsInCents(), self::identicalTo(10000));
    }

    public function testCalculate_suta_location_replaces_state_unemployment(): void
    {
        $suta_location = new GeoPoint(0.0, 0.0);
        $work_location = new GeoPoint(1.0, 1.0);

        $suta_area_id = $this->makeAreaAtPoint($suta_location);
        $this->makeTaxArea(StateUnemploymentTax1::class, $suta_area_id);

        $work_area_id = $this->makeAreaAtPoint($work_location);
        $this->makeTaxArea(StateUnemploymentTax2::class, $work_area_id);

        $wage = $this->makeWage($work_location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $work_location,
            $suta_location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        self::assertNull($tax_results->get(StateUnemploymentTax2::class));

        /* @var TaxResult $tax */
        $tax = $tax_results->get(StateUnemploymentTax1::class);
        self::assertThat(
            $tax->getAmountInCents(),
            self::equalTo(10000 * StateUnemploymentTax1::TAX_RATE)
        );
        self::assertThat($tax->getEarningsInCents(), self::identicalTo(10000));
    }

    public function testCalculate_disabled_tax_removed(): void
    {
        $location = new GeoPoint(0.0, 0.0);

        $area_id = $this->makeAreaAtPoint($location);
        $this->makeTaxArea(StateIncomeTax1::class, $area_id);
        $this->makeTaxArea(LocalTax1::class, $area_id);

        $wage = $this->makeWage($location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([StateIncomeTax1::class]),
            collect([]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));
        self::assertNull($tax_results->get(StateIncomeTax1::class));
    }

    public function testCalculate_pretax_deduction_removed(): void
    {
        $location = new GeoPoint(0.0, 0.0);

        $area_id = $this->makeAreaAtPoint($location);
        $this->makeTaxArea(StateIncomeTax1::class, $area_id);

        $wage = $this->makeWage($location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([StateIncomeTax1::class => 10]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        /* @var TaxResult $tax */
        $tax = $tax_results->get(StateIncomeTax1::class);
        self::assertThat(
            $tax->getAmountInCents(),
            self::equalTo(9000 * StateIncomeTax1::TAX_RATE)
        );
        self::assertThat($tax->getEarningsInCents(), self::identicalTo(9000));
    }

    public function testCalculate_base_tax_pretax_deduction_removed(): void
    {
        $location = new GeoPoint(0.0, 0.0);

        $area_id = $this->makeAreaAtPoint($location);
        $this->makeTaxArea(LocalTax1::class, $area_id);

        $wage = $this->makeWage($location);

        $tax_results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now()->addWeek(),
            Carbon::now()->addWeek()->addDays(4),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([BaseLocal::class => 10]),
            0,
            collect([]),
            collect([])
        );

        self::assertThat($tax_results->count(), self::identicalTo(1));

        /* @var TaxResult $tax */
        $tax = $tax_results->get(LocalTax1::class);
        self::assertThat(
            $tax->getAmountInCents(),
            self::equalTo(9000 * LocalTax1::TAX_RATE)
        );
        self::assertThat($tax->getEarningsInCents(), self::identicalTo(9000));
    }

    public function testCalculate_unresolvable_date(): void
    {
        $short_name = (new ReflectionClass(AlabamaIncome::class))->getShortName();
        $this->expectExceptionMessage("The implementation for $short_name 2016-01-01 could not be found.");

        $coords = $this->getLocation('us.alabama.birmingham');
        $location = new GeoPoint($coords[0], $coords[1]);

        $this->taxes->calculate(
            Carbon::parse('2016-01-01'),
            Carbon::parse('2016-01-01'),
            Carbon::parse('2016-01-01'),
            $location,
            $location,
            collect([]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([])
        );
    }

    public function testCalculate_no_user(): void
    {
        $coords = $this->getLocation('us.alabama.birmingham');
        $location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($location, 6668);

        $results = $this->taxes->calculate(
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            null,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(688));
        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(40));
        self::assertThat($results->get(Medicare::class)->getAmountInCents(), self::identicalTo(97));
        self::assertThat($results->get(MedicareEmployer::class)->getAmountInCents(), self::identicalTo(97));
        self::assertThat($results->get(SocialSecurity::class)->getAmountInCents(), self::identicalTo(413));
        self::assertThat($results->get(SocialSecurityEmployer::class)->getAmountInCents(), self::identicalTo(413));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(206));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(180));
        self::assertThat($results->get(BirminghamOccupational::class)->getAmountInCents(), self::identicalTo(67));
    }

    public function testGetStateIncomeClass(): void
    {
        $class = $this->taxes->getStateIncomeClass(GeorgiaIncome::class, $this->user, Carbon::parse('2018-01-01'));

        $this->assertSame(GeorgiaIncome::DEPENDENT_ALLOWANCE_AMOUNT, $class::DEPENDENT_ALLOWANCE_AMOUNT);
    }

    public function testCalculate_additional_withholding(): void
    {
        Carbon::setTestNow('2017-01-01');

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 10,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 10,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

        $coords = $this->getLocation('us.alabama');
        $location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($location, 1000);

        $results = $this->taxes->calculate(
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            1,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->count(), self::identicalTo(8));
        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(923));
        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(6));
        self::assertThat($results->get(Medicare::class)->getAmountInCents(), self::identicalTo(15));
        self::assertThat($results->get(MedicareEmployer::class)->getAmountInCents(), self::identicalTo(15));
        self::assertThat($results->get(SocialSecurity::class)->getAmountInCents(), self::identicalTo(62));
        self::assertThat($results->get(SocialSecurityEmployer::class)->getAmountInCents(), self::identicalTo(62));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(27));

        $wage = $this->makeWage($location, 1100);
        $results = $this->taxes->calculate(
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            1,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(1000));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(15));
    }

    public function testCalculate_negative_additional_withholding(): void
    {
        Carbon::setTestNow('2017-01-01');

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => -10,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => -10,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

        $coords = $this->getLocation('us.alabama.birmingham');
        $location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($location, 1000);
        $results = $this->taxes->calculate(
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            1,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(0));

        $wage = $this->makeWage($location, 1100);
        $results = $this->taxes->calculate(
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            Carbon::parse('2017-01-01'),
            $location,
            $location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            1,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(0));
    }

    public function testCalculate_unbinds_payroll_after(): void
    {
        $this->expectException(BindingResolutionException::class);

        $coords = $this->getLocation('us.alabama');
        $location = new GeoPoint($coords[0], $coords[1]);

        $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            52,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        app(Payroll::class);
    }

    public function testCalculate_date(): void
    {
        Carbon::setTestNow('2017-01-01');

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

        $coords = $this->getLocation('us.alabama.birmingham');
        $location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($location, 6668);
        $supplemental_wage = $this->makeSupplementalWage($location, 668);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([$wage, $supplemental_wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(754));
        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(40));
        self::assertThat($results->get(Medicare::class)->getAmountInCents(), self::identicalTo(97));
        self::assertThat($results->get(MedicareEmployer::class)->getAmountInCents(), self::identicalTo(97));
        self::assertThat($results->get(SocialSecurity::class)->getAmountInCents(), self::identicalTo(413));
        self::assertThat($results->get(SocialSecurityEmployer::class)->getAmountInCents(), self::identicalTo(413));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(203));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(180));
        self::assertThat($results->get(BirminghamOccupational::class)->getAmountInCents(), self::identicalTo(67));

        Carbon::setTestNow('2018-01-01');

        $coords = $this->getLocation('us.georgia');
        $ga_location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($ga_location, 6668);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $ga_location,
            $ga_location,
            collect([$wage]),
            collect([]),
            collect([]),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect([
                'AL' => 0.027,
                'GA' => 0.027,
            ])
        );

        self::assertThat($results->get(ParentGeorgiaIncome::class)->getAmountInCents(), self::identicalTo(273));
        self::assertThat($results->get(GeorgiaUnemployment::class)->getAmountInCents(), self::identicalTo(180));
    }

    public function testCalculate_ytd(): void
    {
        Carbon::setTestNow('2017-07-01');

        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

        $coords = $this->getLocation('us.alabama.birmingham');
        $location = new GeoPoint($coords[0], $coords[1]);

        $wage = $this->makeWage($location, 6668);
        $supplemental_wage = $this->makeSupplementalWage($location, 668);

        $historical_wage = $this->makeWageAtDate(Carbon::now()->subMonth(), $location, 700000);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([$wage, $supplemental_wage]),
            collect([]),
            $this->makeAnnualTaxableWages(700000),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(0));

        $historical_wage = $this->makeWageAtDate(Carbon::now()->subMonth(), $location, 800000);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([$wage, $supplemental_wage]),
            collect([]),
            $this->makeAnnualTaxableWages(800000),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(0));

        $historical_wage = $this->makeWageAtDate(Carbon::now()->subMonth(), $location, 12720000);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([$wage, $supplemental_wage]),
            collect([]),
            $this->makeAnnualTaxableWages(12720000),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalUnemployment::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(SocialSecurity::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(SocialSecurityEmployer::class)->getAmountInCents(), self::identicalTo(0));

        $historical_wage = $this->makeWageAtDate(Carbon::now()->subMonth(), $location, 20000000);

        $results = $this->taxes->calculate(
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            $location,
            $location,
            collect([$wage, $supplemental_wage]),
            collect([]),
            $this->makeAnnualTaxableWages(20000000),
            collect([]),
            $this->user,
            null,
            260,
            collect([]),
            collect([]),
            collect([]),
            0,
            collect([]),
            collect(['AL' => 0.027])
        );

        self::assertThat($results->get(FederalIncome::class)->getAmountInCents(), self::identicalTo(754));
        self::assertThat($results->get(Medicare::class)->getAmountInCents(), self::identicalTo(157));
        self::assertThat($results->get(MedicareEmployer::class)->getAmountInCents(), self::identicalTo(97));
        self::assertThat($results->get(AlabamaIncome::class)->getAmountInCents(), self::identicalTo(203));
        self::assertThat($results->get(AlabamaUnemployment::class)->getAmountInCents(), self::identicalTo(0));
        self::assertThat($results->get(BirminghamOccupational::class)->getAmountInCents(), self::identicalTo(67));
    }

    private function makeAnnualTaxableWages(int $amount): Collection
    {
        $annual_taxable_wages = collect([]);

        $annual_taxable_wages->put(FederalUnemployment::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), FederalUnemployment::class, $amount),
        ]));
        $annual_taxable_wages->put(Medicare::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), Medicare::class, $amount),
        ]));
        $annual_taxable_wages->put(MedicareEmployer::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), MedicareEmployer::class, $amount),
        ]));
        $annual_taxable_wages->put(SocialSecurity::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), SocialSecurity::class, $amount),
        ]));
        $annual_taxable_wages->put(SocialSecurityEmployer::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), SocialSecurityEmployer::class, $amount),
        ]));
        $annual_taxable_wages->put(AlabamaIncome::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), AlabamaIncome::class, $amount),
        ]));
        $annual_taxable_wages->put(AlabamaUnemployment::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), AlabamaUnemployment::class, $amount),
        ]));
        $annual_taxable_wages->put(BirminghamOccupational::class, collect([
            $this->makeTaxableWageAtDate(Carbon::now()->subMonth(), BirminghamOccupational::class, $amount),
        ]));

        return $annual_taxable_wages;
    }
}
