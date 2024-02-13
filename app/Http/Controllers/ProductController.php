<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $category_id = $request->get('category_id');
        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');
        $sort = $request->get('sort');

        $query = Product::select('category_id', 'name', 'maker', 'price', 'id');
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // if ($keyword) {
        //     $query->where('name', 'LIKE', "%$keyword%")
        //         ->orWhere('maker', 'LIKE', "%$keyword%");
        // }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('maker', 'LIKE', "%$keyword%");
            });
        }

        if ($min_price !== null && $max_price !== null) {
            $query->whereBetween('price', [$min_price, $max_price]);
        } elseif ($min_price !== null) {
            $query->where('price', '>=', $min_price);
        } elseif ($max_price !== null) {
            $query->where('price', '<=', $max_price);
        }

        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'added_date') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);

        $data = [
            "products" => $products,
        ];
        // dd($data);

        return view("index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("product.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'maker' => 'required|max:255',
            'price' => 'required|numeric|between:10,199.99',
        ]);

        // dd($request);
        $product = new Product();
        $product->name = $request->name;
        $product->maker = $request->maker;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();

        return redirect(route('top'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = ['product' => $product];
        return view("product.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'maker' => 'required|max:255',
            'price' => 'required|numeric|between:10,199.99',
        ]);

        // dd($request);
        // $product = new Product();
        $product->name = $request->name;
        $product->maker = $request->maker;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->save();
                // dd($product);

        return redirect(route('top', $product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(route('top'));
    }
}
