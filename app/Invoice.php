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
        'building_id', 'object_id', 'amount', 'invoice_date', 'payable_until', 'is_paid', 'invoice_type'
    ];

    /*One-to-many relation between invoices and objects*/
    public function object() {
        return $this->belongsTo('immogate\Object');
    }

    public function building() {
        return $this->belongsTo('immogate\Building');
    }

    protected $invoice_types = [
        'Male',
        'Female'
    ];

    public function getInvoiceTypes(){
        return $this->invoice_types;
    }

    public function getFormattedInvoiceAmount(){
        return number_format($this->attributes['amount'], 2, '.', '');
    }
}
