<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\ICategoryRepo;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * @group Category management
 *
 * APIs for managing Categories
 */
class CategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(ICategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * @unauthenticated
     */
    public function all()
    {
        return Response::Ok($this->categoryRepo->all());
    }

    /**
     * @unauthenticated
     */
    public function getWithSlug(String $slug)
    {
        if (!$category = $this->categoryRepo->getWithSlug($slug))
            return Response::NotFound();

        return Response::Ok($category);
    }

    public function new(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($this->categoryRepo->save($category = new Category(), $validatedData))
            return Response::Created($category);

        return Response::BadRequest('Could not create category.');
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if (!$category = $this->categoryRepo->getWithSlug($slug)) return Response::BadRequest('Category not found.');

        if ($this->categoryRepo->save($category, $validatedData))
            return Response::Ok($category);

        return Response::BadRequest('Could not update category.');
    }

    public function delete($slug)
    {
        if (!$category = $this->categoryRepo->getWithSlug($slug)) return Response::BadRequest('Category not found.');

        if ($this->categoryRepo->delete($category))
            return Response::NoContent();

        return Response::BadRequest('Could not delete category.');
    }

    /**
     * @unauthenticated
     */
    public function get($slug)
    {
        if (!$category = $this->categoryRepo->get($slug)) return Response::BadRequest('Category not found.');

        return Response::Ok($category);
    }

    /**
     * @unauthenticated
     */
    public function views()
    {
        return Response::Ok($this->categoryRepo->views());
    }

    /**
     * @unauthenticated
     */
    public function likes()
    {
        return Response::Ok($this->categoryRepo->likes());
    }
}
