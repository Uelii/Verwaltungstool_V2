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
        'renter_id', 'amount_total', 'amount_payed', 'is_payed', 'date'
    ];

    public function renter() {
        return $this->belongsTo('immogate\Renter');
    }

    public function getDatabaseValueAmountTotal(){
        return $this->attributes['amount_total'];
    }

    /*public function getFormattedAmountTotal($amount){
        return $this->attributes['amount_total'] = sprintf('Fr. %s', number_format($amount, 2));
    }

    public function getFormattedAmountPaid($amount){
        return $this->attributes['amount_paid'] = sprintf('Fr. %s', number_format($amount, 2));
    }*/
}
