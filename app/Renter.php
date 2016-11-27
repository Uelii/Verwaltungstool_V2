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
        'title', 'first_name', 'last_name', 'email', 'phone_landline', 'phone_mobile_phone', 'street', 'street_number', 'zip_code', 'city', 'is_main_domicile', 'is_main_renter', 'beginning_of_contract', 'end_of_contract'
    ];

    /*Many-to-many relation between renter and objects*/
    public function objects() {
        return $this->belongsToMany('grabem\Object', 'object_renter', 'FK_object_id', 'FK_renter_id');
    }
}
