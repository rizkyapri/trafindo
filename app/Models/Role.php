<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $table = 'tblrole';
    protected $guarded = 'id';

    protected $fillable = [
        'Name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
