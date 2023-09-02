<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Product;
use Illuminate\Http\Request;
use App\ProductIssue;


class IssuesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'company']);
    }
    /*
   * To get all tickets
     *
   *@
   */
    public function index(Request $request,Product $product)
    {

        $productIssues = $product->product_issue_lists();
    //  return($productIssues);
    $productIssues = $request->showOnlyActive ? $productIssues->where('is_active', '=', 1) : $productIssues;
    if (request()->page && request()->rowsPerPage) {
      $count = $productIssues->count();
      $productIssues = $productIssues->paginate(request()->rowsPerPage)->toArray();
      $productIssues = $productIssues['data'];
    }else {
      $productIssues = $productIssues->get();
      $count = $productIssues->count();
    }
    // return($productIssues);

    return response()->json([
      'data'     =>   $productIssues,
      'count'    =>   $count
    ], 200);
    }

    /*
   * To store a new ticket
   *
   *@
   */
    public function store(Request $request , Product $product)
    {
        // $request->validate([
        //     'title'        =>  'required',
        //     'issued_type_id' =>  'required',
        //     'status_type_id' =>  'required',
        //     'created_by_id' =>  'required',
        // ]);

       
        $ProductIssue = new ProductIssue(request()->all());
    $product->value_lists()->save($ProductIssue);

        return response()->json([
            'data'    => $ProductIssue
        ], 201);
    }
    public function storeMultiple(Request $request, Product $product)
    {
    //   $request->validate([
    //     'datas.*.value_id'    =>  'required',
    //     'datas.*.code'        =>  'required',
    //     'datas.*.created_by_id' =>  'required',
    //   ]);
  
      $productLists = [];
      foreach ($request->datas as $productList) {
        if (!isset($productList['id'])) {
          $productList = new ProductIssue($productList);
          $product->product_issue_lists()->save($productList);
          $productLists[] = $productList;
        } else {
          $vL = ProductIssue::find($productList['id']);
          $vL->update($productList);
          $productLists[] = $vL;
        }
      }
     
  
  
      return response()->json([
        'data'    =>  $productLists
      ], 201);
    }
    /*
   * To view a single ticket
   *
   *@
   */

    public function show(Product $product,ProductIssue $productIssue)
    {
      
        return response()->json([
            'data'   => $productIssue,
        ], 200);
    }

    /**
     * To update a ticket
     *
    
     */
    public function update(Request $request, Product $product,ProductIssue $productIssue)
    {
        // $request->validate([
        //     'title'        =>  'required',
        //     'issued_type_id' =>  'required',
        //     'status_type_id' =>  'required',
        //     'created_by_id' =>  'required',
        // ]);


        $productIssue->update($request->all());
        return response()->json([
            'data'  =>  $productIssue,
        ], 200);
    }

    public function destroy(Product $product,$id)
    {
        $productIssue = ProductIssue::find($id);
        $productIssue->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}