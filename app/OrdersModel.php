<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'customer_name',
        'customer_surname',
        'customer_email',
        'customer_mobile',
        'payment_requestId',
        'payment_reason',
        'payment_message',
        'payment_date',
        'payment_reference',
        'payment_description',
        'payment_authorization',
        'payment_currency',
        'payment_total',
        'process_url',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];
}