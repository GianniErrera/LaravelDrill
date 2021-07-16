<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInstance extends Model
{
    use HasFactory;

    protected $table = "events";

    protected $fillable = [
        'date',
        'eventDescription',
        'isItRecurringYearly'
    ];

    public function scopeSearchDate($query, $searchDate) {
        return ($searchDate != null) ? $query->whereDate('date', '=', $searchDate) : $query;
    }

    public function scopeSearch($query, $search) {
        return $query->where('eventDescription', 'like', '%' . $search . '%');
    }

    public function scopeIgnoreYearFromQuery($query, $ignoreYearFromQuery, $startDate, $endDate) {
        return ($ignoreYearFromQuery == true)
        ? $query
        : $query->
            whereYear('date', '>=', date_format(date_create($startDate), 'Y'))->
            whereYear('date', '<=', date_format(date_create($endDate), 'Y'));
    }

    public function scopeStartDate($query, $startDate) {

        return $query->
            whereMonth('date', '>=', date_format(date_create($startDate), 'm'))->
            whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
            orWhereMonth('date', '>', date_format(date_create($startDate), 'm'));
    }

    public function scopeEndDate($query, $endDate) {

        return $query->
            whereMonth('date', '<=', date_format(date_create($endDate), 'm'))->
            whereDay('date', '<=', date_format(date_create($endDate), 'd'))->
            orWhereMonth('date', '<', date_format(date_create($endDate), 'm'));
    }

    public function yearly() {

        return $this->isItRecurringYearly;
    }

}
