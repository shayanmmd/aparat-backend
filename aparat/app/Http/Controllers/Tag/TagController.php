<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Interfaces\Models\Tag\TagRepositoryInterface;

class TagController extends Controller
{
     public function __construct(
        private TagRepositoryInterface $tagRepositoryInterface
    ) {}

    public function create(CreateTagRequest $request)
    {
        $response = $this->tagRepositoryInterface->create($request);
        return $response->json();
    }

    public function all()
    {
        $response = $this->tagRepositoryInterface->all();
        return $response->json();
    }
}
