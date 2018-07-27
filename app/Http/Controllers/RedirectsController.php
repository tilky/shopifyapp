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

	public function edit($id)
	{
		return view('dashboard.update')->with([
			'redirect' => $this->redirectService->getById($id),
			'products' => $this->productService->getAll()
		]);
	}

	public function import()
	{
		return view('dashboard.import');
	}

	/*
	 * Store a redirect
	 */
	public function store(Request $request)
	{
		$redirectType = $request->redirect_type;

		$request->validate([
		    'path' => 'required',
		    $redirectType => 'required',
		]);

		$data = [
			'redirect' => [
				'path' => $request->path,
				'target' => $request->$redirectType
			]
		];

		$result = $this->redirectService->add($data);

		$message = is_object($result) ? 'Successfully added redirect' : 'An error has occured!';

		return back()->with('status', $message);
	}

	public function update(Request $request)
	{
		$data = [
			'redirect' => [
				'id' => $request->id,
				'path' => $request->path,
				'target' => $request->target
			]
		];

		$this->redirectService->update($data, $request->id);

		return back()->with('status', 'Successfully updated redirect');
	}

	/*
	 * Delete a redirect
	 */
	public function destroy($id)
	{
		$this->redirectService->delete($id);

		return back()->with('status', 'Successfully deleted redirect');
	}

	public function processImport(Request $request)
	{
		// @todo handle proper validation
		
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

			$result = $this->redirectService->add($data);

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
