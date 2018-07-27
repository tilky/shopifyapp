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
			'API_KEY' => env('SHOPIFY_API_KEY'),
			'API_SECRET' => env('SHOPIFY_API_SECRET'),
			'SHOP_DOMAIN' => env('SHOPIFY_SHOP_DOMAIN'),
			'ACCESS_TOKEN' => env('SHOPIFY_ACCESS_TOKEN')
		]);
	}

	private function _endpoint($params)
	{
		return $params['endpoint'] . (isset($params['params']) ? '/' . $params['params'] : '') . '.json';
	}

	public function isError()
	{
		
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