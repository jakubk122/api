<?php

namespace App\ProductCatalog;


class ProductCatalogRepository
{
    /**
     * @var ProductsEntity
     */
    private $productsEntity;
    /**
     * @var CurrenciesEntity
     */
    private $currenciesEntity;

    public function __construct(
        ProductsEntity $productsEntity,
        CurrenciesEntity $currenciesEntity
    ) {
        $this->productsEntity = $productsEntity;
        $this->currenciesEntity = $currenciesEntity;
    }

    public function findAllPaginated($currentPage, $limit)
    {
        return $this->productsEntity::query()
            ->paginate($limit,['*'], 'page', $currentPage);
    }

    public function findById(int $productId):? ProductsEntity
    {
        return $this->productsEntity::query()
            ->where('id', $productId)
            ->get()->first();
    }

//    /**
//     * @return array
//     */
//    public function getAllProducts(){
//       return $this->createQueryBuilder('e')
//           ->select('e')
//           ->getQuery()
//           ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
//    }
//
//    public function getProductById($productId){
//       return $this->createQueryBuilder('e')
//            ->select('e')
//            ->where('e.id = '.$productId)
//            ->getQuery()
//            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
//    }
//
//    /**
//     * @param $id
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Exception
//     */
//    public function deleteProduct($id){
//
//        if(!RequestValidator::isValidId($id)){
//            throw new \Exception('Invalid id!');
//        }
//
//       $em = $this->getEntityManager();
//       $product = $this->findOneBy(['id' => $id]);
//
//       if(empty($product)){
//           throw new \Exception('Product dont exists');
//       }
//
//       $em->remove($product);
//       $em->flush();
//    }
//
//    /**
//     * @param $title
//     * @param $price
//     * @throws \Exception
//     */
//    public function addProduct($title,$price){
//        if(!RequestValidator::isValidTitle($title) || !RequestValidator::isValidPrice($price)){
//            throw new \Exception('Invalid parameters passed!');
//        }
//
//        $product = new ProductCatalog();
//        $product->setTitle($title);
//        $product->setPrice($price);
//
//        $em = $this->getEntityManager();
//        $em->persist($product);
//        $em->flush();
//    }

    public function addProduct(
        string $title,
        float $price,
        int $currencyId
    ) {
        $this->productsEntity::query()
            ->insert([
                'title' => $title,
                'price' => $price,
                'currency_id' => $currencyId
            ]);
    }
    public function updateProduct(
        int $productId,
        array $updateData
    ) {
        $this->productsEntity::query()
            ->where('id', $productId)
            ->update($updateData);
    }

    public function findCurrencyByName(string $name):? CurrenciesEntity
    {
        return $this->currenciesEntity::query()
            ->where('name', $name)
            ->get()
            ->first();
    }
//    /**
//     * @param $title
//     * @param $price
//     * @throws \Exception
//     */
//    public function updateProduct($id,$title,$price){
//        if(
//            !RequestValidator::isValidId($id)
//        ){
//            throw new \Exception('Invalid id passed!');
//        }
//
//        $product = $this->findOneBy(['id' => $id]);
//
//        $product->setTitle($title);
//        $product->setPrice($price);
//
//        $em = $this->getEntityManager();
//        $em->persist($product);
//        $em->flush();
//    }
}
