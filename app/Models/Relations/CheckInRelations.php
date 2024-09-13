<?php


namespace App\Models\Relations;

use App\Models\AreaUser;
use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Models\UserCategory;
use App\Models\GeneralFeature;
use App\Models\Question;
use App\Models\Service;
use App\Models\Story;
use App\Models\User;
use App\Models\UserContactList;
use App\Models\UserLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait CheckInRelations
 * @package App\Models\Relations
 */
trait CheckInRelations
{
   


    /**
     * @return HasOne
     */
    public function checkOut()
    {
        return $this->hasOne(CheckOut::class, 'check_in_id');
    }

 /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->BelongsTo(User::class, 'user_id');
    }
 
}
