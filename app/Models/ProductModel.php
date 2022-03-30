<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    /**
     * Referencia o código del producto
     * @var string
     */
    public $reference;

    /**
     * Descripción o nombre del producto
     * @var string
     */
    public $description;
}
