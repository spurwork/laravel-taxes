<?php

namespace Appleton\Taxes\Models;

use Illuminate\Database\Eloquent\Model;

class TaxInformation extends Model
{
    protected $table = 'tax_information';

    protected $guarded = [];

    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        $this->table = config('taxes.tables.tax_information');
    }

    public function user()
    {
        return $this->belongsTo(config('taxes.user'), config('taxes.user_id'));
    }

    public function information()
    {
        return $this->morphTo();
    }

    public function scopeForUser($query, $user)
    {
        return $query->where(config('taxes.user_id'), $user->id);
    }

    public function scopeIsTypeOf($query, $information_type)
    {
        return $query->where('information_type', $information_type);
    }
}
