<?php


namespace App\Traits;
use Carbon\Carbon;

trait FormatDates
{
    protected $newDateFormat = 'd-m-Y H:i:s';


    public function setCreatedAtAttribute($date)
    {

        $this->attributes['created_at'] = Carbon::parse($date);

    }

    public function getCreatedAtAttribute($date)
    {

        return Carbon::parse($date)->format($this->newDateFormat);

    }

    public function setUpdatedAtAttribute($date)
    {

        $this->attributes['updated_at'] = Carbon::parse($date);

    }

    public function getUpdatedAtAttribute($date)
    {

        return Carbon::parse($date)->format($this->newDateFormat);

    }

    public function setDeletedAtAttribute($date)
    {

        $this->attributes['deleted_at'] = Carbon::parse($date);

    }

    public function getDeletedAtAttribute($date)
    {

        return Carbon::parse($date)->format($this->newDateFormat);

    }
}