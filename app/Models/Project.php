<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_date',
        'user_id',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
{
    return $this->belongsToMany(User::class);
}

}
