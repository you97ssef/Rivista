<?php

namespace App\Data;

use App\Interfaces\ICategoryRepo;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepo implements ICategoryRepo
{
    public function all()
    {
        return Category::all();
    }

    public function get($id): ?Category
    {
        return Category::find($id);
    }
    public function getWithSlug(String $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }

    public function rivistas($id)
    {
        // TODO: get only some data to improve performance
        return Category::find($id)->rivisitas;
    }

    public function save(Category $category, array $data): bool
    {
        if (array_key_exists('name', $data)) {
            $category->name = $data['name'];
            $category->slug = Str::slug($data['name']);
        }
        if (array_key_exists('description', $data)) $category->description = $data['description'];
        if (array_key_exists('image', $data)) $category->image = $data['image'];

        return $category->save();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}