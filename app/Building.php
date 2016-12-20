<?php

namespace immogate;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'street', 'street_number', 'zip_code', 'city'
    ];

    /*One-to-many relation between buildings and objects*/
    public function objects() {
        return $this->hasMany('immogate\Object');
    }
}
