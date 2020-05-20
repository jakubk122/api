<?php


namespace App\Cart\Services\Formatter\Http\Products;


use Illuminate\Database\Eloquent\Collection;

class AllCartProductsFormatter
{
    public function format(Collection $cartProducts)
    {
        $formattedCartProductsWithTotalPrice = [];
        $totalPrice = 0;
        foreach ($cartProducts as $cartProduct){
            $formattedCartProductsWithTotalPrice['products'][] = [
                'product_id' => $cartProduct['product_id'],
                'price' => $cartProduct['price'],
                'title' => $cartProduct['title']
            ];
            $totalPrice += $cartProduct['price'];
        }

        $formattedCartProductsWithTotalPrice['totalPrice'] = $totalPrice;

        return $formattedCartProductsWithTotalPrice;
    }
}
