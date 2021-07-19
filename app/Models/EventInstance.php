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

    public function scopeTimeInterval($query, $ignoreYearFromQuery, $startDate, $endDate) {
        $query = $query;
        if ($ignoreYearFromQuery == true) {
            if($startDate) {
                $query->
                whereMonth('date', '>', date_format(date_create($startDate), 'm'))->
                orWhereMonth('date', '=', date_format(date_create($startDate), 'm'))->
                whereDay('date', '>=', date_format(date_create($startDate), 'd'));
               }

            if($endDate) {
                $query->
                orWhereMonth('date', '<', date_format(date_create($endDate), 'm'))-> // orWhere is needed as this is not logically concatenated to previous subquery
                orWhereMonth('date', '=', date_format(date_create($endDate), 'm'))->
                whereDay('date', '<=', date_format(date_create($endDate), 'd'));
               }
        }
        else {
            if($startDate) {
             $query->
                whereDate('date', '>=', date_format(date_create($startDate), 'Y-m-d'));
            }

            if($endDate) {
                $query->
                orWhereDate('date', '<=', date_format(date_create($endDate), 'Y-m-d'));
               }
        }
    }


    public function scopeStartDate($query, $startDate, $endDate) {

        return ($startDate != null) ? $query->
            whereMonth('date', '>=', date_format(date_create($startDate), 'm'))->
            whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
            orWhereMonth('date', '>', date_format(date_create($startDate), 'm'))
            : $query;

    }

    public function scopeEndDate($query, $endDate) {

        return ($endDate != null) ? $query->
            whereMonth('date', '<=', date_format(date_create($endDate), 'm'))->
            whereDay('date', '<=', date_format(date_create($endDate), 'd'))->
            orWhereMonth('date', '<', date_format(date_create($endDate), 'm'))
            : $query;
    }

    public function yearly() {

        return $this->isItRecurringYearly;
    }

}
