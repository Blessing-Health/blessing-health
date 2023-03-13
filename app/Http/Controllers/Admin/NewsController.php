<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsRequest;
use App\Http\Requests\News\NewsStoreRequest;
use App\Models\News;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function index()
    {
        return response(auth()->user()->news);
    }

    public function show(News $news)
    {
        return response($news);
    }

    public function store(NewsRequest $request)
    {
        return auth()->user()->news()->create($request->validated());
    }

    public function destroy(News $news)
    {
        $news->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(NewsRequest $request, News $news)
    {
        return $news->update($request->validated());
    }
}
