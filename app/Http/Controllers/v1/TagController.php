<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateTagRequest;
use App\Http\Requests\v1\UpdateTagRequest;
use App\Http\Resources\v1\TagResource;
use App\Models\Tags;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * Get list of Tags.
     *
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny');

        $tags = Tags::query();
        return TagResource::collection($tags->paginate());
    }

    /**
     * Get the details of Tag.
     *
     * @param Tags $tag
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Tags $tag): JsonResponse
    {
        $this->authorize('view');

        return response()->json([
            'data' => TagResource::make($tag)
        ], Response::HTTP_OK);
    }

    /**
     * Create a new Tag.
     *
     * @param CreateTagRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateTagRequest $request): JsonResponse
    {
        $this->authorize('create');

        $tag = Tags::create($request->all(['name', 'description']));

        return response()->json([
            'message' => 'New tag created successfully.',
            'data' => TagResource::make($tag),
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the Tag details
     *
     * @param UpdateTagRequest $request
     * @param Tags $tag
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTagRequest $request, Tags $tag): JsonResponse
    {
        $this->authorize('update');

        $tag->update($request->all(['name', 'description']));

        return response()->json([
            'message' => 'Tag updated successfully.',
            'data' => TagResource::make($tag),
        ], Response::HTTP_OK);
    }

    /**
     * Delete the Tag.
     *
     * @param Tags $tag
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Tags $tag): JsonResponse
    {
        $this->authorize('delete');

        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully.'
        ], Response::HTTP_OK);
    }
}
