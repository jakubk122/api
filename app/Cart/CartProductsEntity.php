<?php

namespace App\Cart;

use Illuminate\Database\Eloquent\Model;

class CartProductsEntity extends Model
{
    protected $table = 'cart_products';

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getCartId()
    {
        return $this->getAttribute('cart_id');
    }

    public function getProductId()
    {
        return $this->getAttribute('product_id');
    }

    public function setCartId(int $cartId)
    {
        return $this->setAttribute('cart_id', $cartId);
    }

    public function setProductId(int $productId)
    {
        return $this->getAttribute('product_id', $productId);
    }


}

