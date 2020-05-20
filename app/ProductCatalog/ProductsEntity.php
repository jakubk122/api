<?php

namespace App\ProductCatalog;

use Illuminate\Database\Eloquent\Model;

class ProductsEntity extends Model
{
    protected $table = 'products';

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function getPrice()
    {
        return $this->getAttribute('price');
    }

    public function getCurrencyId()
    {
        return $this->getAttribute('currency_id');
    }
}

