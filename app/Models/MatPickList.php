<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatPickList extends Model
{
    use HasFactory;

    protected $table = 'tblMatPickList';
    protected $guarded = 'id';

    protected $fillable = [
        'MatPickID',
        'ItemNumber',
        'ItemName', 
        'Uom',
        'Qty',
        'Notes',
        'QtyMod'
    ];

    public function matpick()
    {
        return $this->belongsTo(MatPick::class);
    }   
}
