<?php

namespace App\ProductCatalog;

use Illuminate\Database\Eloquent\Model;

class CurrenciesEntity extends Model
{
    protected $table = 'currencies';

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getName()
    {
        return $this->getAttribute('name');
    }

}

