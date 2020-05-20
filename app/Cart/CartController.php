<?php

namespace App\Cart;

use App\Cart\Services\Formatter\Http\Products\AllCartProductsFormatter;
use App\Cart\Services\Products\AddProductService;
use App\Core\Services\JsonResponses\JsonResponseHandlerService;
use App\Core\Exception\ExceptionHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller;

class CartController extends Controller
{
    const MAX_ITEMS_IN_CART_QUANTITY = 3;

    /**
     * @var CartRepository
     */
    private $cartRepository;
    /**
     * @var JsonResponseHandlerService
     */
    private $jsonResponseHandlerService;
    /**
     * @var AddProductService
     */
    private $addProductService;
    /**
     * @var AllCartProductsFormatter
     */
    private $allCartProductsFormatter;

    public function __construct(
        CartRepository $cartRepository,
        JsonResponseHandlerService $jsonResponseHandlerService,
        AddProductService $addProductService,
        AllCartProductsFormatter $allCartProductsFormatter
    ) {
        $this->cartRepository = $cartRepository;
        $this->jsonResponseHandlerService = $jsonResponseHandlerService;
        $this->addProductService = $addProductService;
        $this->allCartProductsFormatter = $allCartProductsFormatter;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createCartAction(Request $request)
    {
        try{
            $cartUuid = Str::uuid()->toString();
            $this->cartRepository->create($cartUuid);

            return $this->jsonResponseHandlerService->getJsonResponse($cartUuid);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addProductToCartAction(Request $request)
    {
        try{
            $this->validate($request, [
                'uuid' => 'required|uuid',
                'productId' => 'required|integer',
                'quantity' => 'required|integer'
            ]);

            $cartUuid = $request->input('uuid');
            $productId = $request->input('productId');
            $quantity = $request->input('quantity');

            if(count($this->cartRepository->findAllProducts($cartUuid)) + 1 > self::MAX_ITEMS_IN_CART_QUANTITY){
                return $this->jsonResponseHandlerService->getJsonResponse(
                    'You can\'t add more than ' . self::MAX_ITEMS_IN_CART_QUANTITY . ' products to cart.',
                        Response::HTTP_NOT_MODIFIED
                    );
            }

            $cart = $this->cartRepository->findCartByUuid($cartUuid);

            if(empty($cart)){
                return $this->jsonResponseHandlerService->getJsonResponse(
                    'Can\'t find cart with given uuid',
                    Response::HTTP_NOT_FOUND
                );
            }

            $this->addProductService->addProductToCart($cart, $productId, $quantity);

            return $this->jsonResponseHandlerService->getJsonResponse(Response::$statusTexts[Response::HTTP_OK]);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    public function deleteProductFromCartAction(Request $request)
    {
        try{
            $cartUuid = $request->input('uuid');
            $productId = $request->input('productId');
            $cartProduct = $this->cartRepository->findProductByCartUuidAndProductId($cartUuid, $productId);
            if(empty($cartProduct)){
                throw new \Exception('Cant find product with given id in cart with given uuid');
            }

            $this->cartRepository->removeProductFromCart($cartProduct['cart_id'], $cartProduct['product_id']);

            return $this->jsonResponseHandlerService->getJsonResponse('OK');
        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    public function getAllCartProductsAction($cartUuid)
    {
        try{
            $products = $this->cartRepository->findAllProducts($cartUuid);
            if($products->isEmpty()){
                throw new \Exception('There isn\'t any products in a cart!');
            }

            return $this->allCartProductsFormatter->format($products);
        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }

    }
}
