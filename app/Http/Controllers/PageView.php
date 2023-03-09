<?php

namespace App\Http\Controllers;

use FacebookAds\Object\BusinessDataAPI\UserData;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Event;
use Illuminate\Support\Str;

class PageView extends Event
{
    public static function create(): static
    {
        return (new static())
            ->setActionSource(ActionSource::WEBSITE)
            ->setEventName('PageView')
            ->setEventTime(time())
            ->setEventSourceUrl(request()->fullUrl())
            ->setEventId((string) Str::uuid())
            ->setUserData(UserData::getUserData());
    }
}