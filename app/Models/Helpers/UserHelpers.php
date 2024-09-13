<?php

namespace App\Models\Helpers;

use App\Events\ServiceProviderUpdatedEvent;
use App\Globals\CONSTANTS;
use App\Models\AreaUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Str;

/**
 * Trait UserHelpers
 * @package App\Models\Helpers
 */
trait UserHelpers
{
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'default_locale' => $this->default_locale,
            'bio' => $this->bio,
            'profile' => $this->profile,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'status' => (int)$this->status,
            'score' => (double)$this->score,
            'rate_count' => (int)$this->ratings()->count(),
            'rate_avg' => (float)$this->averageRating(),
            'min_price' => $this->getMinServicePrice(),
            'max_price' => $this->getMaxServicePrice(),
            'sub_categories' => $this->getServicesCategories()['sub_categories'],
            'categories' => $this->getServicesCategories()['categories'],
            'services_count' => (int)$this->services()->count(),
            'deleted' => $this->deleted_at ? 1 : 0,
            'centers' => $this->getAllCenters(),
            'polygon_coordinates' => [
                "type" => 'multipolygon',
                'coordinates' => $this->getAllPolygons(),
            ],
            'recommended' => (int)$this->recommended,
            'progress_complete' => (int)$this->progress_complete,
            'sponsored' => (int)$this->sponsored,
            'free_shipping' => (int)$this->free_shipping,
            'shipping_info' => $this->shipping_info,
            'is_global' => (int)$this->is_global,

        ];
    }

    /**
     * @return float|null
     */
    protected function getMinServicePrice()
    {

        $service = $this->services()->where('status', CONSTANTS::ACCEPTED_STATUS)->orderBy('price', 'asc')->first();

        if ($service) {
            return (float)$service->price;
        }

        return 0;
    }

    /**
     * @return float|null
     */
    protected function getMaxServicePrice()
    {
        $service = $this->services()->where('status', CONSTANTS::ACCEPTED_STATUS)->orderBy('price', 'desc')->first();

        if ($service) {
            return (float)$service->price;
        }

        return 0;
    }

    /**
     * @return array
     */
    protected function getServicesCategories()
    {
        $categories = DB::table('services')
            ->join('service_category', 'service_category.service_id', '=', 'services.id')
            ->join('categories', 'service_category.category_id', '=', 'categories.id')
            ->whereNull('categories.deleted_at')
            ->where('services.user_id', '=', $this['id'])
            ->get(['categories.id', 'categories.parent_id']);

        return [
            'sub_categories' => array_values(array_unique($categories->pluck('id')->toArray())),
            'categories' => array_values(array_unique($categories->pluck('parent_id')->toArray())),
        ];
    }

    public function setWorkDaysAttribute($value)
    {
        if (!$value) {
            $value = [];
        }

        $this->attributes['work_days'] = json_encode($value);
    }

    /**
     * @return bool
     */
    public function isServiceProvider()
    {
        return $this->services()->where('status', CONSTANTS::ACCEPTED_STATUS)->count()
            and
            $this->defaultServiceAreas()->count()
            and
            $this->defaultLocation()
            and
            $this->status == CONSTANTS::ACCEPTED_STATUS;
    }

    public function getAllCenters()
    {

        $locations = [];
        $userLocations = $this->defaultLocation();

        if ($userLocations) {
            array_push($locations, [
                'lat' => floatval($userLocations->lat),
                'lon' => floatval($userLocations->lon),
            ]);
        }
        return $locations;
    }

    public function getAllPolygons()
    {
        /** @var array $usersPolygons */
        $usersPolygons = $this->serviceAreas()->pluck('polygon')->toArray();

        /** @var array $polygons */
        $polygons = [];

        foreach ($usersPolygons ?? [] as $polygon) {
            array_push($polygons, [$polygon]);
        }

        return $polygons;
    }

    public function createGlobalServiceArea($location, $user_default = 0)
    {
        DB::transaction(
            function () use ($location, &$serviceArea, &$user_default) {
                $serviceArea = $this->serviceAreas()->create([
                    'lat' => $location->lat,
                    'lon' => $location->lon,
                    'diameter' => CONSTANTS::Earth_Diameter,
                    'user_default' => $user_default,
                    'polygon' => transformCircleToPolygon(CONSTANTS::Earth_Diameter, $location->lat, $location->lon)
                ]);

                try {
                    event(new ServiceProviderUpdatedEvent(auth()->user()));
                } catch (\Exception $exception) {
                    throw ValidationException::withMessages(['polygon' => __('messages.polygon_not_valid')]);
                }
            }
        );
    }
   
}
