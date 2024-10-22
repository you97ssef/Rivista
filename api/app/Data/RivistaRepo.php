<?php

namespace App\Data;

use App\Interfaces\IRivistaRepo;
use App\Models\Rivista;
use Illuminate\Support\Str;

class RivistaRepo implements IRivistaRepo
{
    public function paginate()
    {
        return Rivista::withCount('likes')->paginate();
    }

    public function get($id): ?Rivista
    {
        return Rivista::find($id);
    }

    public function getWithSlug(String $slug): ?Rivista
    {
        return Rivista::with('comments', 'comments.user')->withCount('likes')->where('slug', $slug)->first();
    }

    // public function likes($id)
    // {
    //     return Rivista::find($id)->likes;
    // }

    // public function comments($id)
    // {
    //     return Rivista::find($id)->comments;
    // }

    // public function category($id)
    // {
    //     return Rivista::find($id)->category;
    // }

    // public function user($id)
    // {
    //     return Rivista::find($id)->user;
    // }

    public function save(Rivista $rivista, array $data): bool
    {
        if (array_key_exists('title', $data)) {
            $rivista->title = $data['title'];
            $rivista->slug = Str::slug($data['title'] . ' ' . Str::random(10));
        }
        if (array_key_exists('text', $data)) $rivista->text = $data['text'];
        if (array_key_exists('image', $data)) $rivista->image = $data['image'];
        if (array_key_exists('views', $data)) $rivista->views = $data['views']; 
        if (array_key_exists('user_id', $data)) $rivista->user_id = $data['user_id'];
        if (array_key_exists('category_id', $data)) $rivista->category_id = $data['category_id'];

        return $rivista->save();
    }

    public function delete(Rivista $rivista): bool
    {
        return $rivista->delete();
    }
    
    public function views()
    {
        return Rivista::withCount('likes')->orderBy('views', 'desc')->paginate();
    }

    public function likes()
    {
        return Rivista::withCount('likes')->orderBy('likes_count', 'desc')->paginate();
    }
}
