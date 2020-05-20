<?php

namespace App\Cart;

use Illuminate\Database\Eloquent\Model;

class CartEntity extends Model
{
    protected $table = 'cart';

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUuid()
    {
        return $this->getAttribute('uuid');
    }
}

