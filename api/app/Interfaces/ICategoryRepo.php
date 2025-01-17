<?php

namespace App\Interfaces;

use App\Models\Category;

interface ICategoryRepo
{
    public function all();
    public function get($slug): ?Category;
    public function getWithSlug(String $slug): ?Category;

    // public function rivistas($id);

    public function save(Category $category, array $data): bool;

    public function delete(Category $category): bool;

    public function views();
    public function likes();
}
