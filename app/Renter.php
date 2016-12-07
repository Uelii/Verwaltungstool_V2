<?php

namespace grabem;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'renter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id', 'title', 'first_name', 'last_name', 'email', 'phone_landline', 'phone_mobile_phone', 'street', 'street_number', 'zip_code', 'city', 'is_main_domicile', 'beginning_of_contract', 'end_of_contract'
    ];

    public function object() {
        return $this->belongsTo('grabem\Object');
    }

    public function payments() {
        return $this->hasMany('grabem\Payment');
    }
}
