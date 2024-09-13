<?php

namespace App\Models;

use App\Models\Relations\CheckOutRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckOut extends Model
{
    use HasFactory,SoftDeletes,CheckOutRelations;
    /**
    * @var string[]
    */
   protected $fillable = [
       'created_at',
       'check_in_id',
       'deleted_at'

   ];
   /** @var array */
   protected $casts = [
       'created_at' => 'datetime:Y-m-d H:i:s',

   ];
}

