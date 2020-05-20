<?php

namespace App\ProductCatalog;

use App\Core\Services\JsonResponses\JsonResponseHandlerService;
use App\Core\Exception\ExceptionHelper;
use App\ProductCatalog\Services\Formatter\Http\AllPaginatedProductsFormatter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller;

class ProductCatalogController extends Controller
{
    const MAX_PRODUCTS_PER_PAGE = 3;

    /**
     * @var ProductCatalogRepository
     */
    private $productCatalogRepository;
    /**
     * @var JsonResponseHandlerService
     */
    private $jsonResponseHandlerService;
    /**
     * @var AllPaginatedProductsFormatter
     */
    private $allPaginatedProductsFormatter;

    public function __construct(
        ProductCatalogRepository $productCatalogRepository,
        JsonResponseHandlerService $jsonResponseHandlerService,
        AllPaginatedProductsFormatter $allPaginatedProductsFormatter
    ){
        $this->productCatalogRepository = $productCatalogRepository;
        $this->jsonResponseHandlerService = $jsonResponseHandlerService;
        $this->allPaginatedProductsFormatter = $allPaginatedProductsFormatter;
    }

    public function addProductAction(Request $request)
    {
        try{
            $this->validate($request, [
                'title' => 'required|string',
                'price' => 'required|numeric',
                'currencyName' => 'required|string|min:3|max:3',
            ]);
            $title = $request->input('title');
            $price = $request->input('price');
            $currencyName = $request->input('currencyName');
            $currency = $this->productCatalogRepository->findCurrencyByName($currencyName);

            if(empty($currency)){
                throw new \Exception('Currency with given name doesn\'t exist');
            }

            $this->productCatalogRepository->addProduct(
                $title,
                $price,
                $currency->getId()
            );

            return $this->jsonResponseHandlerService->getJsonResponse('OK', Response::HTTP_OK);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    public function updateProductAction(Request $request)
    {
        try{
            $this->validate($request,[
                'id' => 'required|integer',
                'title' => 'string',
                'price' => 'numeric',
                'currencyName' => 'string|min:3|max:3',
            ]);

            $productId = $request->input('id');
            $title = $request->input('title');
            $price = $request->input('price');
            $currencyName = $request->input('currencyName');

            $updateData = [];

            if(!empty($title)){
                $updateData['title'] = $title;
            }

            if(!empty($price)){
                $updateData['price'] = $price;
            }

            if(!empty($currencyName)){
                $updateData['currencyName'] = $currencyName;
            }

            $this->productCatalogRepository->updateProduct($productId, $updateData);

            return $this->jsonResponseHandlerService->getJsonResponse('OK', Response::HTTP_OK);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    public function deleteProductAction(Request $request)
    {
        try{
            $this->validate($request,[
               'id' => 'required|integer'
            ]);
            $productId = $request->input('id');
            $product = $this->productCatalogRepository->findById($productId);

            if(empty($product)){
               return $this->jsonResponseHandlerService->getJsonResponse('Product with given id not found', Response::HTTP_NOT_FOUND);
            }

            $product->delete();

            return $this->jsonResponseHandlerService->getJsonResponse('OK', Response::HTTP_OK);
        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    public function getAllPaginatedAction($currentPage)
    {
        try{
            $paginatedProducts = $this->productCatalogRepository->findAllPaginated($currentPage, self::MAX_PRODUCTS_PER_PAGE);

            return $this->allPaginatedProductsFormatter->format($paginatedProducts);

        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }

    }

}
