<?php
namespace App\Cart;

use AppBundle\Entity\ProductsEntity;
use AppBundle\Utils\ProductCatalog\RequestValidator;
use AppBundle\Exception\InvalidDataException;
use Illuminate\Database\Eloquent\Collection;

class CartRepository
{
    /**
     * @var CartEntity
     */
    private $cartEntity;
    /**
     * @var CartProductsEntity
     */
    private $cartProducts;

    public function __construct(
        CartEntity $cartEntity,
        CartProductsEntity $cartProducts
    ) {
        $this->cartEntity = $cartEntity;
        $this->cartProducts = $cartProducts;
    }

    public function create(string $uuid)
    {
        $this->cartEntity::query()
            ->insert([
                [
                    'uuid' => $uuid
                ]
            ]);
    }

    public function findCartByUuid(string $uuid):? CartEntity
    {
        return $this->cartEntity::query()
            ->where('uuid','=', $uuid)
            ->get()
            ->first();
    }

    public function findAllProducts(string $cartUuid): Collection
    {
       return $this->cartEntity::query()
            ->where('uuid', $cartUuid)
            ->join('cart_products','cart.id', '=', 'cart_products.cart_id')
            ->join('products', 'cart_products.product_id','=','products.id')
            ->get();
    }

    public function findProductByCartUuidAndProductId(string $cartUuid, int $productId){
       return $this->cartEntity::query()
            ->where('uuid', $cartUuid)
            ->where('cart_products.product_id', $productId)
            ->join('cart_products','cart.id', '=', 'cart_products.cart_id')
            ->join('products', 'cart_products.product_id','=','products.id')
            ->get()
           ->first();
    }

    public function addProductToCart(int $cartId, int $productId, int $quantity)
    {
        $this->cartProducts::query()
            ->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
    }

    public function updateProductInCart(string $cartId, int $productId, array $dataToUpdate)
    {
        $this->cartProducts::query()
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->update($dataToUpdate);
    }

    public function removeProductFromCart(string $cartId, int $productId)
    {
        return $this->cartProducts::query()
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->delete();
    }


}
