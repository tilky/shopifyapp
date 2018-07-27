<?php

namespace App\Services;

use App;

class ShopifyApiService
{
	private $shopify;

	/*
	 * Initialise API with credentials
	 */
	public function __construct()
	{
		$this->shopify = App::make('ShopifyAPI', [
			'API_KEY' => config('shopify.SHOPIFY_API_KEY'),
			'API_SECRET' => config('shopify.SHOPIFY_API_SECRET'),
			'SHOP_DOMAIN' => config('shopify.SHOPIFY_SHOP_DOMAIN'),
			'ACCESS_TOKEN' => config('shopify.SHOPIFY_ACCESS_TOKEN')
		]);
	}

	/*
	 * Derive the endpoint
	 */
	private function _endpoint(array $params)
	{
		return $params['endpoint'] . (isset($params['params']) ? '/' . $params['params'] : '') . '.json';
	}

	/**
	 * Perform an API call
	 * @param  string $endpoint The endpoint to call
	 * @param  array  $data     Data to send
	 * @param  string $method   HTTP call method
	 * @return array            Api response
	 */
	public function call($endpoint, $data = [], $method = 'GET')
	{
		$endpoint = $this->_endpoint($endpoint);

		try {
			$result = $this->shopify->call([ 
		        'METHOD'    => $method, 
		        'URL'       => $endpoint,
		        'DATA'		=> $data
		    ]);
		}
		catch(\Exception $e)
		{
			$result = $e->getMessage();
		}

		return $result;
	}
}