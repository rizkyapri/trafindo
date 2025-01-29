<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatPick extends Model
{
    use HasFactory;

    protected $table = 'tblMatPick';
    protected $guarded = 'id';

    protected $fillable = [
        'MatPickNumber',
        'OprID',
        'EmployeeID', 
        'MatPickDescription',
        'MatPickIssuedDate',
        'Notes'
    ];
    
    public function employees()
    {
        return $this->belongsTo(Employees::class);
    }   

    public function matpicklist()
    {
        return $this->hasMany(MatPickList::class);
    }   

    public function woopr()
    {
        return $this->belongsTo(WOOpr::class);
    }   

}
