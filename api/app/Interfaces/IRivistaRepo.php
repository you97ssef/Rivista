<?php

namespace App\Interfaces;

use App\Models\Rivista;

interface IRivistaRepo
{
    public function all();
    public function get($id): ?Rivista;
    public function getWithSlug(String $slug): ?Rivista;

    public function likes($id);
    public function comments($id);
    public function category($id);
    public function user($id);

    public function save(Rivista $rivista, array $data): bool;

    public function delete(Rivista $rivista): bool;
}
