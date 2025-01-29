<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AndonCategory extends Model
{
    use HasFactory;

    protected $table = 'tblAndonCat';
    protected $guarded = 'id';

    protected $fillable = [
        'CodeAndon',
        'CategoryProblem',
        'AssignTo',
        'Guard_EmployeeID',
        'ContactPerson',
        'HP_WA',
        'Sirene',
        'AndonSerie'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function employee(){
        return $this->belongsTo(Employees::class, 'Guard_EmployeeID', 'id');
    }

    public function andonno(){
        return $this->hasMany(AndonNo::class);
    }

    public function andon(){
        return $this->hasMany(Andon::class);
    }
}
