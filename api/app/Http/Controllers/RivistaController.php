<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\IRivistaRepo;
use App\Models\Rivista;
use Illuminate\Http\Request;

class RivistaController extends Controller
{
    private $rivistaRepo;

    public function __construct(IRivistaRepo $rivistaRepo)
    {
        $this->rivistaRepo = $rivistaRepo;
    }

    public function paginate()
    {
        return Response::Ok($this->rivistaRepo->paginate());
    }

    public function getWithSlug(String $slug)
    {
        // TODO get likes count and comments with
        // TODO get user with
        if (!$rivista = $this->rivistaRepo->getWithSlug($slug)) return Response::NotFound('Rivista not found');

        $data['views'] = $rivista->views + 1;

        $this->rivistaRepo->save($rivista, $data);

        return Response::Ok($this->rivistaRepo->getWithSlug($slug));
    }

    public function new(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $validatedData['user_id'] = $request->user()->id;
        $validatedData['views'] = 0;

        if ($this->rivistaRepo->save($rivista = new Rivista(), $validatedData))
            return Response::Created($rivista);

        return Response::BadRequest('Could not create this rivista.');
    }

    public function update($id, Request $request)
    {
        if (!$rivista = $this->rivistaRepo->get($id)) return Response::BadRequest('Rivista not found');

        if ($rivista->user_id != $request->user()->id) return Response::BadRequest('You are not the owner of this rivista');

        $validatedData = $request->validate([
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'text' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        if ($this->rivistaRepo->save($rivista, $validatedData))
            return Response::Ok($rivista);

        return Response::BadRequest('Could not update this rivista.');
    }

    public function delete($id, Request $request)
    {
        if (!$rivista = $this->rivistaRepo->get($id)) return Response::BadRequest('Rivista not found');

        if ($rivista->user_id != $request->user()->id) return Response::BadRequest('You are not the owner of this rivista');

        if ($this->rivistaRepo->delete($rivista))
            return Response::NoContent();

        return Response::BadRequest('Could not delete this rivista.');
    }
}
