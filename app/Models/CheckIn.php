<?php

namespace App\Models;

use App\Models\Relations\CheckInRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckIn extends Model
{
    use HasFactory,SoftDeletes,CheckInRelations;
     /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'created_at',
        'deleted_at'
    ];
    /** @var array */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',

    ];

    // public function scopeWithAndWhereHas($query, $relation, $constraint)
    // {
    //     return $query->whereHas($relation, $constraint)
    //         ->with([$relation => $constraint]);
    // }
  
}
