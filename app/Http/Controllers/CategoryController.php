<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\IndexCategoryRequest;

use App\Models\Category;

use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCategoryRequest $request)
    {        
        $filters = $request->validated();
        $query = Category::query();
            $query->when(isset($filters['search']), function ($query) use ($filters) {
        $query->where(
            'name',
            'like',
            '%' . $filters['search'] . '%'
                );
            });
        $categories = Category::paginate(10);

         return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest  $request)
    {
        $category = Category::create([
        'name' => $request->validated('name'),
        ]);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('prodects');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

            return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
