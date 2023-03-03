<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const UPDATE_FREQUENCY_DEFAULT = 0;
    const UPDATE_FREQUENCY_MINUTE = 60;
    const UPDATE_FREQUENCY_10_MINUTE = 600;
    const UPDATE_FREQUENCY_HOUR = 3600;
    const UPDATE_FREQUENCY_DAY = 86400;


    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'update_frequency_second',
        'status',
    ];

    public static function getArrrayStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getStatus()
    {
        $status = self::getArrrayStatus();
        return $status[$this->status];
    }

    public static function getArrayUpdateFrequency()
    {
        return [
            self::UPDATE_FREQUENCY_DEFAULT => 'No update',
            self::UPDATE_FREQUENCY_MINUTE => '1 minute',
            self::UPDATE_FREQUENCY_10_MINUTE => '10 minute',
            self::UPDATE_FREQUENCY_HOUR => '1 hour',
            self::UPDATE_FREQUENCY_DAY => '1 day',
        ];
    }

    public function getUpdateFrequency()
    {
        $updateFrequency = self::getArrayUpdateFrequency();
        return $updateFrequency[$this->update_frequency_second];
    }


}
