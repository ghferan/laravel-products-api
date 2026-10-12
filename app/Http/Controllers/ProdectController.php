<?php

namespace App\Http\Controllers;

use App\Models\Prodect;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests\IndexProductRequest;

use App\Http\Resources\ProductResource;

class ProdectController extends Controller
{
        
    public function index(IndexProductRequest $request)
    {
        //  $this->authorize('viewAny', Prodect::class);
        $filters = $request->validated();

        // $query = Prodect::query();
        $query = Prodect::with('category');

        // if (isset($filters['search'])) {
        //     $query->where('name', 'like', '%' . $filters['search'] . '%');
        // }
        $query->when(isset($filters['search']), function ($query) use ($filters) {
        $query->where('name', 'like', '%' . $filters['search'] . '%');
            });

        $query->when(isset($filters['min_price']), function ($query) use ($filters) {
            $query->where('price', '>=', $filters['min_price']);
        });

        $query->when(isset($filters['max_price']), function ($query) use ($filters) {
            $query->where('price', '<=', $filters['max_price']);
        });
        
        $query->when(isset($filters['sort']), function ($query) use ($filters) {
            $query->orderBy(
                'price',
                $filters['sort'] === 'price_asc' ? 'asc' : 'desc'
            );
        });

        $query->when(isset($filters['category_id']), function ($query) use ($filters) {
        $query->where('category_id', $filters['category_id']);
        });
        
        $prodects = $query->paginate(10);

        return ProductResource::collection($prodects);
    }
        
    public function store(StoreProductRequest $request)
        {
            $this->authorize('create', Prodect::class);

            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')
                    ->store('products', 'public');
            }

            $product = Prodect::create($data);

            $product->load('category');

            return (new ProductResource($product))
                ->response()
                ->setStatusCode(201);
        }

        public function show(Prodect $product)
        {
            $this->authorize('view', $product);

            return new ProductResource($product);
        }

    public function update(UpdateProductRequest  $request, Prodect $product)
    {
    $this->authorize('update', $product);
        // $product->update($request->only([
        //     'name',
        //     'price',
        //     'description',
        // ]));
        $product->update($request->validated());
        $product->load('category');
        return new ProductResource($product);
        }

    public function destroy(Prodect $product)
        {
            $this->authorize('delete', $product);
        
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully'
            ]);
        }
}
