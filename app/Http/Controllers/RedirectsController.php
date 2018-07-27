<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\RedirectService;
use App\Services\ProductService;
use Excel;

class RedirectsController extends Controller
{
	private $redirectService;
	private $productService;

	public function __construct(RedirectService $redirectService, ProductService $productService)
	{
		$this->middleware('auth');

		$this->redirectService = $redirectService;
		$this->productService = $productService;
	}

	/*
	 * Show all redirects view
	 */
	public function index()
	{
		$redirectsCount = $this->redirectService->getCount();

		$redirects = collect($this->redirectService->getAll())->sortByDesc('id');

		return view('dashboard.index')->with([
			'redirects' => $redirects,
			'redirectsCount' => $redirectsCount
		]);
	}

	/*
	 * Create redirect view
	 */
	public function create()
	{
		return view('dashboard.create')->with([
			'products' => $this->productService->getAll()
		]);
	}

	public function edit(int $id)
	{
		return view('dashboard.update')->with([
			'redirect' => $this->redirectService->getById($id),
			'products' => $this->productService->getAll()
		]);
	}

	/*
	 * Import redirects view
	 */
	public function import()
	{
		return view('dashboard.import');
	}

	/**
	 * Store a redirect
	 * @param  Request $request
	 * @return redirect back
	 */
	public function store(Request $request)
	{
		$redirectType = $request->redirect_type;

		// validation
		$request->validate([
		    'path' => 'required',
		    $redirectType => 'required'
		]);

		$data = [
			'redirect' => [
				'path' => $request->path,
				'target' => $request->$redirectType
			]
		];

		$result = $this->redirectService->add($data);

		return back()->with('status', $result);
	}

	/**
	 * Update a redirect
	 * @param  Request $request
	 * @return redirect back
	 */
	public function update(Request $request)
	{
		// validation
		$request->validate([
		    'id' => 'required|integer',
		    'path' => 'required',
		    'target' => 'required'
		]);

		$data = [
			'redirect' => [
				'id' => $request->id,
				'path' => $request->path,
				'target' => $request->target
			]
		];

		$result = $this->redirectService->update($data, $request->id);

		return back()->with('status', $result);
	}

	/**
	 * Delete a redirect
	 * @param  int $id ID of the redirect
	 * @return redirect back
	 */
	public function destroy(int $id)
	{
		$result = $this->redirectService->delete($id);

		return back()->with('status', $result);
	}

	/**
	 * Process the import using csv file
	 * @param  Request $request Contains the CSV file
	 * @return redirect back
	 */
	public function processImport(Request $request)
	{
		// validation
		$request->validate([
		    'redirects_csv' => 'required|file'
		]);
		
		$errors = new \Illuminate\Support\MessageBag;
		$linesImported = 0;

		Excel::load($request->file('redirects_csv'))->each(function(Collection $csvLine, $key) use($errors, &$linesImported) {
			$line = $key + 2;	// account for index start, and line 1 being headers
			$path = $csvLine->get('path') ?? "";
			$target = $csvLine->get('target') ?? "";

			$data = [
				'redirect' => [
					'path' => $path,
					'target' => $target
				]
			];

			$result = $this->redirectService->add($data, true);

			if(is_object($result)) {
				$linesImported++;
			}
			else {
				$errors->add($line, 'Line ' . $line . ' failed to import');
			}

		});

		return back()->withErrors($errors->messages())->with(['status' => $linesImported . ' redirects have been imported successfully']);
	}

}
