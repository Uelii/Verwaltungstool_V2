<?php

namespace immogate;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id', 'object_id', 'amount', 'invoice_date', 'payable_until', 'is_paid', 'invoice_type', 'user_id'
    ];

    /*One-to-many relation between invoices and objects*/
    public function object() {
        return $this->belongsTo('immogate\Object');
    }

    public function building() {
        return $this->belongsTo('immogate\Building');
    }
}
