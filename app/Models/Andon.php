<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Andon extends Model
{
    use HasFactory;

    protected $table = 'tblAndon';
    protected $guarded = 'id';

    protected $fillable = [
        'Andon_No',
        'Andon_Serie',
        'Guard_ID',
        'Guard_Name',
        'Guard_HPWA',
        'Workcenter',
        'RiseUp_EmployeeNo',
        'RiseUp_EmployeeName',
        'RiseUp_OprNo',
        'DescriptionProblem',
        'AndonDateOpen',
        'AndonDateReceived',
        'Received_EmployeeID',
        'DescriptionSolving',
        'AndonDateSolving',
        'Solved_EmployeeID',
        'AndonDateAccepted',
        'Solving_Score',
        'AndonRemark',
        'AndonDateClosed'
        // 'MatPickID'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($andon) {
            $andon->AndonDateOpen = now();
        });
    }

    public function AndonCat()
    {
        return $this->belongsTo(AndonCategory::class);
    }


    public function andonNo()
    {
        return $this->belongsTo(AndonNo::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'Guard_ID', 'EmployeeNumber');
    }
    
}
