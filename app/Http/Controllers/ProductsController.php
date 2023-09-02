<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Value;

class ProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['company']);
  }

  public function index(Request $request)
  {
    $count = 0;
    if ($request->search) {
      $products = request()->company->products()
        ->where('code', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $products->count();
    } else if (request()->page && request()->rowsPerPage) {
      $products = request()->company->products();
      $count = $products->count();
      $products = $products->paginate(request()->rowsPerPage)->toArray();
      $products = $products['data'];
    } else {
      $products = request()->company->products;
      $count = $products->count();
    }

    return response()->json([
      'data'     =>  $products,
      'count'    =>   $count
    ], 200);
  }

  /*
   * To store a new value
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'code'          =>  'required',
      'created_by_id' =>  'required',
    ]);

    $value = new Product(request()->all());
    $request->company->products()->save($value);

    return response()->json([
      'data'    =>  $value
    ], 201);
  }

  /*
   * To view a single value
   *
   *@
   */
  public function show(Product $product)
  {
    return response()->json([
      'data'   =>  $product,
      'success' =>  true
    ], 200);
  }

  /*
   * To update a value
   *
   *@
   */
  public function update(Request $request, Product $product)
  {
    $product->update($request->all());

    return response()->json([
      'data'  =>  $product
    ], 200);
  }

  public function destroy($id)
  {
    $product = Product::find($id);
    $product->delete();

    return response()->json([
      'message' =>  'Deleted'
    ], 204);
  }
}
