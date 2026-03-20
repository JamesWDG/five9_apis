<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\BlogCms\CreateBlogRequest;
use App\Http\Requests\Api\CMS\BlogCms\UpdateBlogRequest;
use App\Http\Requests\Api\CMS\BlogPageCms\UpdateBannerSectionRequest;
use App\Models\Blog;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogsPageCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'blogs')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Blogs Page Sections list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getBannerSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Banner Section'  && $section->page == 'blogs') {
                return response()->json([
                    'status' => true,
                    'message' => 'Banner section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Banner section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateBannerSection(UpdateBannerSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Banner Section' && $section->page == 'blogs') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Banner section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Banner section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function index(Request $request): JsonResponse
    {
        try {
            $data = DB::table('blogs')
                ->select([
                    'blogs.id',
                    'blogs.slug',
                    'blogs.title',
                    'blogs.featured_image',
                    'blogs.short_description',
                    // 'blogs.description',
                    // 'blogs.file',
                    'blogs.date',
                    'blogs.created_at',
                    'blogs.updated_at',
                ])
                ->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Blogs list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function store(CreateBlogRequest $request): JsonResponse
    {
        try {
            $blog = Blog::create($request->sanitized());
            return response()->json([
                'status' => true,
                'message' => 'Blog created successfully',
                'data' => $blog->fresh(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function show(Blog $blog): JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Blog details retrieved successfully',
                'data' => $blog
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function update(UpdateBlogRequest $request, Blog $blog): JsonResponse
    {
        try {
            $blog->update($request->sanitized());
            return response()->json([
                'status' => true,
                'message' => 'Blog updated successfully',
                'data' => $blog->fresh(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
