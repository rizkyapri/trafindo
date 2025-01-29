<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmployeesTasks extends Model
{
    use HasFactory;

    protected $table = 'tblEmployeesTasks';
    protected $guarded = 'id';

    protected $fillable = [
        'EmployeeID',
        'OprID',
        'TaskDateStart', 
        'TaskDateEnd',
        'TaskStatus'
    ];

    public function woopr()
    {
        return $this->belongsTo(WOOpr::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employees::class, 'EmployeeID');
    }

    // public function getDurationInHoursAttribute()
    // {
    //     $start = Carbon::parse($this->TaskDateStart);
    //     $end = Carbon::parse($this->TaskDateEnd);

    //     return $end->diffInHours($start);
    // }

}
