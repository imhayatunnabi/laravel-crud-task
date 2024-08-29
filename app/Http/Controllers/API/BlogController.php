<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use App\Events\BlogUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Retrieve a list of blogs based on the search criteria.
     *
     * @param Request $request The request object containing search parameters.
     * @return Response A response with the list of blogs and a success status code.
     */
    public function index(Request $request)
    {
        $perPage = request()->input('perPage', 20);
        $search = request()->input('search');
        $blogs = Blog::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')->paginate($perPage);
        return $this->responseWithSuccess('Blog List', $blogs, Response::HTTP_OK);
    }
    /**
     * Store a new blog entry in the database.
     *
     * @param BlogStoreRequest $blogStoreRequest The request object containing the blog data.
     * @return Response A response indicating the success or failure of the blog creation.
     */
    public function store(BlogStoreRequest $blogStoreRequest)
    {

        try {
            DB::beginTransaction();
            $blog = Blog::create($blogStoreRequest->validated());
            DB::commit();
            return $this->responseWithSuccess('Blog Created Successfully', $blog, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Blog creation failed: ', ['exception' => $th]);
            return $this->responseWithError('Blog Creation Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Retrieve a blog entry based on the provided slug.
     *
     * @param string $slug The unique identifier of the blog entry.
     * @return Response A response indicating the success or failure of finding the blog entry.
     */

    public function edit($slug)
    {
        $blog = Blog::findBySlug($slug);
        if ($blog) {
            return $this->responseWithSuccess('Blog Found', $blog, Response::HTTP_OK);
        } else {
            return $this->responseWithError('Blog Not Found', '', Response::HTTP_NOT_FOUND);
        }
    }
    /**
     * Update a specific blog entry in the database based on the provided slug.
     *
     * @param BlogUpdateRequest $blogUpdateRequest The request object containing the updated blog data.
     * @param string $slug The unique identifier of the blog entry to be updated.
     * @return Response A response indicating the success or failure of the blog update operation.
     */
    public function update(BlogUpdateRequest $blogUpdateRequest, $slug)
    {
        $blog = Blog::findBySlug($slug);
        if (!$blog) {
            return $this->responseWithError('Blog Not Found', [], Response::HTTP_NOT_FOUND);
        }
        try {
            DB::beginTransaction();
            if (!$blog) {
                return $this->responseWithError('Blog Not Found', [], Response::HTTP_NOT_FOUND);
            }
            $blog->update($blogUpdateRequest->valslugated());
            DB::commit();
            event(new BlogUpdated($blog, auth()->user()));
            return $this->responseWithSuccess('Blog Updated Successfully', $blog, Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Blog update failed: ', ['exception' => $th]);
            return $this->responseWithError('Blog Update Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Delete a blog entry from the database based on the provided slug.
     *
     * @param string $slug The unique identifier of the blog entry to be deleted.
     * @return Response A response indicating the success or failure of the blog deletion operation.
     */
    public function destroy($slug)
    {
        $blog = Blog::findBySlug($slug);
        if (!$blog) {
            return $this->responseWithError('Blog Not Found', [], Response::HTTP_NOT_FOUND);
        }

        try {
            DB::beginTransaction();
            $blog->delete();
            DB::commit();
            return $this->responseWithSuccess('Blog Deleted Successfully', [], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Blog deletion failed: ', ['exception' => $th]);
            return $this->responseWithError('Blog Deletion Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
