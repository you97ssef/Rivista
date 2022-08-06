<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\ICategoryRepo;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(ICategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function all()
    {
        return Response::Ok($this->categoryRepo->all());
    }

    public function getWithSlug(String $slug)
    {
        // TODO get rivistats with
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

    public function get($slug)
    {
        if (!$category = $this->categoryRepo->get($slug)) return Response::BadRequest('Category not found.');

        return Response::Ok($category);
    }

    public function views()
    {
        return Response::Ok($this->categoryRepo->views());
    }

    public function likes()
    {
        return Response::Ok($this->categoryRepo->likes());
    }
}
