<?php

namespace App\Services;

class RedirectService
{
	private $shopifyApiService;

	private static $endpoints = [
		'redirects' => '/admin/redirects',
		'redirects_count' => '/admin/redirects/count',
	];

	public function __construct(ShopifyApiService $shopifyApiService)
	{
		$this->shopifyApiService = $shopifyApiService;
	}

	/**
	 * Get all redirects
	 * @return array Redirects
	 */
	public function getAll()
	{
		$redirects = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects']])->redirects;

		return $redirects;
	}

	/**
	 * Get redirect by id
	 * @param  int $id Redirect identifer
	 * @return array Redirect
	 */
	public function getById(int $id)
	{
		return $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id])->redirect;
	}

	/**
	 * Get total number of redirects
	 * @return int total count
	 */
	public function getCount()
	{
		$count = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects_count']])->count;

		return (int) $count;
	}

	/**
	 * Add a redirect
	 * @param array $data Contains path and target data
	 * @return Response
	 */
	public function add(array $data, $returnResult = false)
	{
		$result = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects']], $data, 'POST');

		if($returnResult) {
			return $result;
		}
		
		return is_object($result) ? 'Successfully added redirect' : 'An error has occured!';
	}

	/**
	 * Delete a redirect
	 * @param  int    $id Redirect identifier
	 * @return Response
	 */
	public function delete(int $id)
	{
		$result = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id], [], 'DELETE');

		return is_object($result) ? 'Successfully deleted redirect' : 'An error has occured!';
	}

	/**
	 * Update a redirect
	 * @param  array  $data Contains path and target data to update
	 * @param  int    $id   Redirect identifier
	 * @return Response
	 */
	public function update(array $data, int $id)
	{
		$result = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id], $data, 'PUT');

		return is_object($result) ? 'Successfully updated redirect' : 'An error has occured!';
	}
}