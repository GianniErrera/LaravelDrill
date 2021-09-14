<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'date',
        'EventDescription',
        'isItRecurringYearly'
    ];

    public function scopeSearchDate($query, $ignoreYearFromQuery, $searchDate) {
        if($ignoreYearFromQuery == false) {
            return ($searchDate != null) ? $query->whereDate('date', '=', $searchDate) : $query;
        } elseif ($ignoreYearFromQuery == true && $searchDate != "") {
            $month = date_format(date_create($searchDate), 'm');
            $day = date_format(date_create($searchDate), 'd');
            return $query->whereMonth('date', $month)
             ->whereDay('date', $day);
         }
    }

    public function scopeSearch($query, $search) {
        return $query->where('eventDescription', 'like', '%' . $search . '%');
    }

    public function scopeTimeInterval($query, $ignoreYearFromQuery, $startDate, $endDate) {

        if ($ignoreYearFromQuery == true) {

            if($startDate && $endDate) {
                $rangeStartMonth = date_format(date_create($startDate), 'm');
                $rangeStartDay = date_format(date_create($startDate), 'd');
                $rangeEndMonth = date_format(date_create($endDate), 'm');
                $rangeEndDay = date_format(date_create($endDate), 'd');

                if($rangeStartMonth == $rangeEndMonth) { // if startDate and endDate are on the same month, we must take all days in between range
                    $query->
                        whereMonth('date', '=', $rangeStartMonth)->
                        whereDay('date', '>=', $rangeStartDay)->
                        whereDay('date', '<=', $rangeEndDay);
                } else {
                    $query->
                        whereMonth('date', '>', $rangeStartMonth)-> // take all months between start and end date, if any
                        whereMonth('date', '<', $rangeEndMonth)->
                        orWhereMonth('date', '=', $rangeStartMonth)->
                        whereDay('date', '>=', $rangeStartDay)->
                        orWhereMonth('date', '=', $rangeEndMonth)->
                        whereDay('date', '<=', $rangeEndDay);
                }

            } else {
                return $query; // if required parameters are not provided just return the query
            }

        } else { // date query when ignoreYearFromQuery is false

            if($startDate && $endDate) {
             $query->
                whereDate('date', '>=', date_format(date_create($startDate), 'Y-m-d'))->
                whereDate('date', '<=', date_format(date_create($endDate), 'Y-m-d'));
            } else {
                return $query; // if required parameters are not provided just return the query
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
