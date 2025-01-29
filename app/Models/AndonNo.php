<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AndonNo extends Model
{
    use HasFactory;

    protected $table = 'tblAndonNo';
    protected $guarded = 'id';

    protected $fillable = [
        'Andon_No',
        'Andon_Color',
        'Workcenter',
        'CodeAndon'
    ];

    public function andoncat(){
        return $this->belongsTo(AndonCategory::class);
    }

    public function andon(){
        return $this->hasMany(Andon::class);
    }
    
}
