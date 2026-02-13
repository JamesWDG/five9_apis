<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\HeaderCms\UpdateChildNavigationMetaRequest;
use App\Http\Requests\Api\CMS\HeaderCms\UpdateHeaderButtonRequest;
use App\Http\Requests\Api\CMS\HeaderCms\UpdateLogoRequest;
use App\Http\Requests\Api\CMS\HeaderCms\UpdateNavigationMetaRequest;
use App\Models\Cms;
use App\Models\CmsMeta;
use App\Models\CmsMetaValue;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HeaderCmsController extends Controller
{
    function headerMainList()
    {
        try {
            $data = Cms::where('page', 'header')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Header CMS list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateLogo(UpdateLogoRequest $request, Cms $headerLogo): JsonResponse
    {
        if ($headerLogo->type !== 'Header Logo') {
            return response()->json([
                'status' => false,
                'message' => 'Logo not found'
            ], 404);
        }

        if (!$request->hasFile('logo')) {
            return response()->json([
                'status' => false,
                'message' => 'No logo file provided'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Get uploaded file
            $file = $request->file('logo');

            // Create a unique filename
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Move file to public/images/header_logos
            $destinationPath = public_path('images/header_logos');
            $file->move($destinationPath, $filename);

            // Full public URL
            $publicUrl = asset('images/header_logos/' . $filename);

            // Update logo meta
            $logoMeta = $headerLogo->metas()->where('meta_key', 'logo')->firstOrFail();
            $logoMeta->update(['meta_value' => $publicUrl]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Header logo updated successfully',
                'data' => $logoMeta
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function headerNavigationsList(Cms $headerNavigation)
    {
        try {
            if ($headerNavigation->type !== 'Header Navigation') {
                return response()->json([
                    'status' => false,
                    'message' => 'Header navigation not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Header Navigation list retrieved successfully',
                'data' => $headerNavigation->metas,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getHeaderNavigation(CmsMeta $navigation)
    {
        try {
            if ($navigation->meta_key !== 'navigation') {
                return response()->json([
                    'status' => false,
                    'message' => 'Header navigation not found'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Navigation retrieved successfully',
                'data' => $navigation->load([
                    'cmsMetaValues' => function ($q) {
                        $q->whereNull('parent_id')
                            ->with('children');
                    }
                ]),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function updateNavigationMetaValue(UpdateNavigationMetaRequest $request, CmsMeta $headerNavigationMeta): JsonResponse
    {
        try {
            if ($headerNavigationMeta->meta_key !== 'navigation' || $headerNavigationMeta?->cms?->page != 'Header') {
                return response()->json([
                    'status' => false,
                    'message' => 'Header navigation meta not found'
                ], 404);
            }
            DB::beginTransaction();
            $headerNavigationMeta->update([
                'meta_value' => $request->input('navigation', $headerNavigationMeta?->meta_value),
            ]);
            $metaValue = $headerNavigationMeta->cmsMetaValues()->first();

            if ($metaValue) {
                $metaValue->update([
                    'value' => $request->input('url', $metaValue->value),
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Header navigation meta updated successfully',
                'data' => $headerNavigationMeta->load('cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getChildNavigation(CmsMetaValue $childNavigations): JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Child navigation retrieved successfully',
                'data' => $childNavigations->load('parent.cmsMeta'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateChildNavigationMetaValue(UpdateChildNavigationMetaRequest $request, CmsMetaValue $childMetaValue): JsonResponse
    {
        try {
            DB::beginTransaction();

            // update title if provided
            if ($request->has('title')) {
                $childMetaValue->update([
                    'key'   => $request->input('title'),
                    'value' => $request->input('url'),
                ]);
            }

            // // update or create URL row under this child
            // $urlRow = $childMetaValue->children()->where('key', 'url')->first();
            // if ($urlRow) {
            //     $urlRow->update(['value' => $request->input('url')]);
            // } else {
            //     $childMetaValue->children()->create([
            //         'key'   => 'url',
            //         'value' => $request->input('url'),
            //     ]);
            // }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Child navigation meta updated successfully',
                'data'   => $childMetaValue->load('children'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getHeaderButton(Cms $headerButton): JsonResponse
    {
        try {
            if ($headerButton->type !== 'Header Button') {
                return response()->json([
                    'status' => false,
                    'message' => 'Header button not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Header Button retrieved successfully',
                'data' => $headerButton->load('metas'),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateHeaderButton(UpdateHeaderButtonRequest $request, Cms $headerButton): JsonResponse
    {
        try {
            DB::beginTransaction();
            foreach ($headerButton->metas as $meta) {
                if ($meta->meta_key === 'button text') {
                    $meta->update(['meta_value' => $request->input('button_text')]);
                } elseif ($meta->meta_key === 'button url') {
                    $meta->update(['meta_value' => $request->input('button_url')]);
                }
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Header button updated successfully',
                'data' => $headerButton,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
