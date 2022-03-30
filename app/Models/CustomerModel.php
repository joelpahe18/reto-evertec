<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends AbstractModel
{
    /**
     * Nombre del cliente
     * @var string
     */
    public $name;

    /**
     * Correo electronico del cliente
     * @var string
     */
    public $email;

    /**
     * Celular del cliente
     * @var string
     */
    public $mobile;
}
