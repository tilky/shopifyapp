<?php

namespace App\Services;

class ProductService
{
	private $shopifyApiService;

	private static $endpoints = [
		'products' => '/admin/products'
	];

	public function __construct(ShopifyApiService $shopifyApiService)
	{
		$this->shopifyApiService = $shopifyApiService;
	}

	/*
	 * Get all products
	 */
	public function getAll()
	{
		$products = $this->shopifyApiService->call(['endpoint' => self::$endpoints['products']])->products;
		
		return $products;
	}
}