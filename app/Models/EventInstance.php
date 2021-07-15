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

    public function yearly() {

        return $this->isItRecurringYearly;
    }

}
