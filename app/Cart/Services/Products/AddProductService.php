<?php


namespace App\Cart\Services\Products;


use App\Cart\CartEntity;
use App\Cart\CartRepository;

class AddProductService
{
    /**
     * @var CartRepository
     */
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addProductToCart(
        CartEntity $cart,
        int $productId,
        int $quantity
    ) {
        $cartProduct = $this->cartRepository->findProductByCartUuidAndProductId($cart->getUuid(), $productId);

        if($quantity > 10){
            throw new \Exception('Quantity of one product cant be greater than 10');
        }

        if(!empty($cartProduct)){
            $newProductQuantity = $cartProduct['quantity'] + $quantity;
            if($newProductQuantity > 10){
                throw new \Exception('Quantity of one product cant be greater than 10');
            }

            $this->cartRepository->updateProductInCart($cartProduct['cart_id'], $productId,
                [
                    'quantity' => $newProductQuantity
                ]);
        }else{
            $this->cartRepository->addProductToCart($cart->getId(), $productId, $quantity);
        }
    }
}
