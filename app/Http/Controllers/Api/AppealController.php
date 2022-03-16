<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppealRequest;
use App\Http\Resources\AppealResource;
use App\Models\Appeal;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = Appeal::with('category')->get();

        return AppealResource::collection($appeals);
    }

    public function show($id)
    {
        $appeal = Appeal::findOrFail($id);

        return new AppealResource($appeal->load('category'));
    }

    public function store(AppealRequest $request)
    {
        $appeal = Appeal::create($request->all());

        return new AppealResource($appeal->load('category'));
    }

    public function update(AppealRequest $request, $id)
    {
        $appeal = Appeal::with('category')->findOrFail($id);

        $appeal->update($request->all());

        return new AppealResource($appeal);
    }

    public function delete($id)
    {
        Appeal::findOrFail($id)->delete();
    }
}
