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

	public function getById($id)
	{
		return $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id])->redirect;
	}

	public function getCount()
	{
		$count = $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects_count']])->count;

		return $count;
	}

	/**
	 * Store a redirect
	 * @param  string $path   redirect source
	 * @param  string $target redirect target
	 */
	public function add(array $data)
	{
		return $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects']], $data, 'POST');
	}

	public function delete(int $id)
	{
		return $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id], [], 'DELETE');
	}

	public function update(array $data, int $id)
	{
		return $this->shopifyApiService->call(['endpoint' => self::$endpoints['redirects'], 'params' => $id], $data, 'PUT');
	}
}