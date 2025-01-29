<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignWO extends Model
{
    use HasFactory;

    protected $table = 'tblAssign';
    protected $guarded = 'id';

    protected $fillable = [
        'EmployeeID',
        'OprID',
        'AssignStatus',
    ];

    public function woopr()
    {
        return $this->belongsTo(WOOpr::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employees::class);
    }
}
