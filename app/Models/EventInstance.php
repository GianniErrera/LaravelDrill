<?php

namespace App\Models;

use DateTime;
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

            if($startDate && $endDate) {
                $rangeStartMonth = date_format(date_create($startDate), 'm');
                $rangeStartDay = date_format(date_create($startDate), 'd');
                $rangeEndMonth = date_format(date_create($endDate), 'm');
                $rangeEndDay = date_format(date_create($endDate), 'd');
                $startDateNoYear = DateTime::createFromFormat('m-d', $rangeStartMonth . "-" . $rangeStartDay);
                $endDateNoYear = DateTime::createFromFormat('m-d', $rangeEndMonth . "-" . $rangeEndDay);

                if($rangeStartMonth == $rangeEndMonth) {
                    $query->
                        whereMonth('date', '=', date_format(date_create($startDate), 'm'))->
                        whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
                        whereDay('date', '<=', date_format(date_create($endDate), 'd'))->
                        orWhereMonth('date', '=', date_format(date_create($startDate), 'm'));
                }
                elseif($startDateNoYear <= $endDateNoYear) {  // if start date is less or equal end date we take all dates over the range between them
                    dd($query->
                        whereMonth('date', '>', date_format(date_create($startDate), 'm'))->
                        whereMonth('date', '<', date_format(date_create($endDate), 'm'))->
                        orWhereMonth('date', '=', date_format(date_create($startDate), 'm'))->
                        whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
                        orWhereMonth('date', '=', date_format(date_create($endDate), 'm'))->
                        whereDay('date', '<=', date_format(date_create($endDate), 'd')));
                }

                else {
                    $query->
                        whereMonth('date', '>', date_format(date_create($startDate), 'm'))->
                        orWhereMonth('date', '=', date_format(date_create($startDate), 'm'))->
                        whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
                        orWhereMonth('date', '<', date_format(date_create($endDate), 'm'))-> // orWhere is needed as this is not logically concatenated to previous subquery
                        orWhereMonth('date', '=', date_format(date_create($endDate), 'm'))->
                        whereDay('date', '<=', date_format(date_create($endDate), 'd'));;

                }

            }

            elseif($startDate) { // these two elseifs are only triggered if checkbox is checked but only start date or end date is picked
            $query->
            whereMonth('date', '>', date_format(date_create($startDate), 'm'))->
            orWhereMonth('date', '=', date_format(date_create($startDate), 'm'))->
            whereDay('date', '>=', date_format(date_create($startDate), 'd'));
            }

            elseif($endDate) {
            $query->
            orWhereMonth('date', '<', date_format(date_create($endDate), 'm'))-> // orWhere is needed as this is not logically concatenated to previous subquery
            orWhereMonth('date', '=', date_format(date_create($endDate), 'm'))->
            whereDay('date', '<=', date_format(date_create($endDate), 'd'));
            }
        }

        else { // date query when checkbox is not checked
            if($startDate) {
             $query->
                whereDate('date', '>=', date_format(date_create($startDate), 'Y-m-d'));
            }

            if($endDate) {
                $query->
                whereDate('date', '<=', date_format(date_create($endDate), 'Y-m-d'));
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
