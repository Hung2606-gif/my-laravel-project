<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'report_date',
        'content',
        'working_hours',
        'user_id',
        'job',

        
    ];

   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}

