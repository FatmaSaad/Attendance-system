<?php


namespace App\Models\Relations;

use App\Models\AreaUser;
use App\Models\CheckIn;
use App\Models\UserCategory;
use App\Models\GeneralFeature;
use App\Models\Question;
use App\Models\Service;
use App\Models\Story;
use App\Models\UserContactList;
use App\Models\UserLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait UserRelations
 * @package App\Models\Relations
 */
trait UserRelations
{
    /**
     * @return HasMany
     */
    public function checkIns()
    {
        return $this->hasMany(CheckIn::class)->withWhereHas('checkOut');
    }
       /**
     * @return HasMany
     */
    public function allCheckIns()
    {
        return $this->hasMany(CheckIn::class)->with('checkOut')->orderBy('id', 'desc');
    }
      /**
     * @return HasOne
     */
    public function activecheckIn()
    {
        return $this->hasOne(CheckIn::class)->latest();
    }
}
