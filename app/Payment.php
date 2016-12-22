<?php

namespace immogate;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id','renter_id', 'amount_total', 'amount_paid', 'is_paid', 'date', 'user_id'
    ];

    public function building() {
        return $this->belongsTo('immogate\Building');
    }

    public function renter() {
        return $this->belongsTo('immogate\Renter');
    }
}
