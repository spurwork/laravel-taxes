<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Virginia\V20190701;

use Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome;
use Appleton\Taxes\Models\Countries\US\Virginia\VirginiaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class VirginiaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-07-01';
    private const LOCATION = 'us.virginia';
    private const TAX_CLASS = VirginiaIncome::class;
    private const TAX_INFO_CLASS = VirginiaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        VirginiaIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'sixty_five_plus_or_blind_exemptions' => 0,
            'additional_withholding' => 0,
            'exempt' => false,
        ], $this->user);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            'test case 01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(817)
                    ->build()
            ],
            'test case 02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(638)
                    ->build()
            ],
            'test case 03' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'sixty_five_plus_or_blind_exemptions' => 2,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(484)
                    ->build()
            ],
            'test case 04' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(13462)
                    ->setExpectedAmountInCents(96)
                    ->build()
            ],
            'test case 05' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(17307)
                    ->setExpectedAmountInCents(101)
                    ->build()
            ],
            'test case 06' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'sixty_five_plus_or_blind_exemptions' => 2,
                    ])
                    ->setWagesInCents(21154)
                    ->setExpectedAmountInCents(117)
                    ->build()
            ],
            'test case 07' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4536)
                    ->build()
            ],
            'test case 08' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4330)
                    ->build()
            ],
            'test case 09' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'sixty_five_plus_or_blind_exemptions' => 2,
                    ])
                    ->setWagesInCents(96154)
                    ->setExpectedAmountInCents(4153)
                    ->build()
            ],
            'test case 10' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(26)
                    ->build()
            ],
            'test case 11' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'test case 12' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'sixty_five_plus_or_blind_exemptions' => 2,
                    ])
                    ->setWagesInCents(13000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'test case 13' => [
                $builder
                    ->setTaxInfoOptions([
                        'exemptions' => 2,
                        'sixty_five_plus_or_blind_exemptions' => 2,
                        'exempt' => true,
                    ])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }
}
