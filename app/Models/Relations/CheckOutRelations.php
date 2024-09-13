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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait CheckOutRelations
 * @package App\Models\Relations
 */
trait CheckOutRelations
{
    /**
     * @return BelongsTo
     */
    public function checkIn()
    {
        return $this->BelongsTo(checkIn::class, 'check_in_id');
    }
}
