<?php

namespace Appleton\Taxes\Models\Countries\US;

use Appleton\Taxes\Models\TaxInformation;
use Illuminate\Database\Eloquent\Model;

class FederalIncomeTaxInformation extends Model
{
    protected $table = 'federal_income_tax_information';

    protected $guarded = [];

    public $timestamps = false;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->table = config('taxes.tables.us.federal_income_tax_information');
    }

    public function taxInformation()
    {
        return $this->morphMany(TaxInformation::class, 'information');
    }
}
