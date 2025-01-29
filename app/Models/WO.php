<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WO extends Model
{
    use HasFactory;

    protected $table = 'tblWO';
    protected $guarded = 'id';

    protected $fillable = [
        'WONumber',
        'WOName',
        'WODescription',
        'WOBeginDate',
        'WOEndDate',
        'WOStatus',
        'IDMFG',
        'WOnborig',
        'FGnborig',
        'BOMnborig',
        'WOqty',
        'WOnote'
        // 'MatPickID'
    ];

    public function woopr()
    {
        return $this->hasMany(WOOpr::class, 'WOID', 'id');
    }
}
