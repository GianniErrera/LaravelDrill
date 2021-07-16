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

    public function scopeExceptCurrentYear($query, $excludeCurrentYear) {
        return ($excludeCurrentYear == true) ? dd('OK')  : $query;
    }

    public function scopeTimeInterval($query, $startDate, $endDate) {
        return ($startDate && $endDate) ? $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)  : $query;
    }

    public function yearly() {

        return $this->isItRecurringYearly;
    }

}
