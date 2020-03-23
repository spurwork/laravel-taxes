<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\TaxInformation;
use Illuminate\Database\Eloquent\Model;

abstract class BaseTaxInformationModel extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public abstract static function getDefault();

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->table = config($this->config_name);
    }

    public function taxInformation()
    {
        return $this->morphMany(TaxInformation::class, 'information');
    }

    public static function createForUser($attributes, $user)
    {
        $tax_information = app(TaxInformation::class);
        $tax_information->user()->associate($user);
        $tax_information->information()->associate(app(get_called_class())->create($attributes));
        $tax_information->save();
        return $tax_information;
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('taxInformation', function ($query) use ($user) {
            $query->forUser($user);
        });
    }
}
