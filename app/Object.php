<?php

namespace App;

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
        'name', 'description', 'size', 'room', 'building_id'
    ];

    /*One-to-many relation between buildings and objects*/
    public function building() {
        return $this->belongsTo('app\Building');
    }
}
