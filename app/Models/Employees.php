<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'tblEmployees';
    protected $fillable = [
        'Name',
        'EmployeeNumber',
        'department_id',
        'Title',
        'Photograph',
        'Notes',
        'InProgress'
    ];

    public function employeestasks()
    {
        return $this->hasMany(EmployeesTasks::class);
    }

    public function woopr()
    {
        return $this->hasOne(WOOpr::class);
    }
    
    public function assign()
    {
        return $this->hasOne(AssignWO::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function matpick()
    {
        return $this->hasMany(MatPick::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
