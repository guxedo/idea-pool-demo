<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idea;
use App\Http\Resources\IdeaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return IdeaResource::collection(Idea::with('user')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return IdeaResource
     */
    public function store(Request $request): IdeaResource
    {
        $idea = Idea::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'impact' => $request->impact,
            'easy' => $request->easy,
            'confidence' => $request->confidence,
            'avg' => $request->avg,
        ]);

        return new IdeaResource($idea);
    }

    /**
     * Display the specified resource.
     *
     * @param Idea $idea
     * @return IdeaResource
     */
    public function show(Idea $idea): IdeaResource
    {
        return new IdeaResource($idea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Idea $idea
     * @return JsonResource | IdeaResource
     */
    public function update(Request $request, Idea $idea)
    {
            // check if currently authenticated user is the owner of the current idea
            if ($request->user()->id !== $idea->user_id) {
                return response()->json(['error' => 'You can only edit your own ideas.'], 403);
            }

            $idea->update($request->only(['title']));

            return new IdeaResource($idea);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Idea $idea
     * @return JsonResource
     */
    public function destroy(Request $request, Idea $idea)
    {
        // check if currently authenticated user is the owner of the current idea
        if ($request->user()->id !== $idea->user_id) {
            return response()->json(['error' => 'You can only edit your own ideas.'], 403);
        }

        $idea->delete();

        return response()->json(null, 204);
    }
}
