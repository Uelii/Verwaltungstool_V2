<?php

namespace immogate;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Object extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id', 'name', 'description', 'living_space', 'number_of_rooms', 'floor_room_number', 'rent'
    ];

    /*One-to-many relation between buildings and objects*/
    public function building() {
        return $this->belongsTo('immogate\Building');
    }

    public function renter() {
        return $this->hasMany('immogate\Renter');
    }

    public function invoices() {
        return $this->hasMany('immogate\Invoice');
    }

    public function getSumOfServiceCharges(){

    }
}
