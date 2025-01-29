<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WOOpr extends Model
{
    use HasFactory;
    // public $timestamps = false;

    protected $table = 'tblWOOpr';
    protected $guarded = 'id';

    protected $fillable = [
        'OprNumber',
        'OprName',
        'OprDescription',
        'Workcenter',
        'Stdhrs',
        'WOID',
        'EmployeeID',
        'OprPlanBegin',
        'OprPlanEnd',
        'OprBeginDate',
        'OprEndDate',
        'OprStatus',
        'StdSetupTime',
        'StdRunTime',
        'Oprnote1',
        'Oprnote2'
        // 'created_at',
        // 'updated_at'
    ];

    public function wo()
    {
        return $this->belongsTo(WO::class, 'WOID','id');
    }

    public function employeestasks()
    {
        return $this->hasMany(EmployeesTasks::class, 'OprID','id');
    }

    public function assign()
    {
        return $this->hasMany(AssignWO::class);
    }

    public function employees()
    {
        return $this->belongsTo(Employees::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'EmployeeID', 'EmployeeNumber');
    }
    public function matpick()
    {
        return $this->hasMany(MatPick::class);
    }
}
