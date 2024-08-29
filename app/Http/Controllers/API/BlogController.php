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
    public function index(Request $request)
    {
        $perPage = request()->input('perPage', 20);
        $search = request()->input('search');
        $blogs = Blog::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')->paginate($perPage);
        return $this->responseWithSuccess('Blog List', $blogs, Response::HTTP_OK);
    }
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

    public function edit($slug)
    {
        $blog = Blog::findBySlug($slug);
        if ($blog) {
            return $this->responseWithSuccess('Blog Found', $blog, Response::HTTP_OK);
        } else {
            return $this->responseWithError('Blog Not Found', '', Response::HTTP_NOT_FOUND);
        }
    }
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
    public function destroy($slug){
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
