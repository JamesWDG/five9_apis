<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\FooterCms\UpdateFooterSectionRequest;
use App\Http\Requests\Api\CMS\HeaderCms\UpdateNavigationMetaRequest;
use App\Models\Cms;
use App\Models\CmsMeta;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterCmsSectionController extends Controller
{
    function getFooterSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'footer')->select('id', 'slug', 'type', 'page')
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Footer CMS list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getFooterSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type != 'Footer Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Footer Section not found'
                ], 404);
            }
            $cards = [];
            $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'cards')->first();
            $values = $meta->cmsMetaValues->values();
            $temp = null;

            foreach ($values as $item) {

                // 🟢 new card start
                if ($item->key === '#title') {

                    // previous card complete → push
                    if ($temp) {
                        $cards[] = $temp;
                    }

                    $temp = [
                        'title' => $item->value,
                        'info_1' => null,
                        'info_2' => null,
                    ];

                    continue;
                }

                // 🟢 fill current card fields
                if ($temp) {
                    if ($item->key === 'info_1') {
                        $temp['info_1'] = $item->value;
                    }

                    if ($item->key === 'info_2') {
                        $temp['info_2'] = $item->value;
                    }
                }
            }

            // 🟢 last card push
            if ($temp) {
                $cards[] = $temp;
            }

            // crud meta se raw values hata do
            $meta->setRelation('cmsMetaValues', collect());

            return response()->json([
                'status' => true,
                'message' => 'Testimonials Section retrieved successfully',
                'data' => [
                    'id'    => $section->id,
                    'type'  => $section->type,
                    'page'  => $section->page,
                    'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                    'cards' => $cards
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateFooterSection(UpdateFooterSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Footer Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Footer Section not found'
                ], 404);
            }

            DB::transaction(function () use ($request, $section) {

                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                $metas = collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));
                $crudMeta = $metas->firstWhere('meta_key', 'crud');

                // 🔵 create cards values
                foreach ($request->sanitizedCards() as $card) {
                    foreach ($card as $key => $value) {

                        $crudMeta->cmsMetaValues()->create([
                            'key' => $key,
                            'value' => $value
                        ]);
                    }
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Footer Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getFooterNavigationSectionList(Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Footer Navigation') {
                return response()->json([
                    'status' => false,
                    'message' => 'Footer Navigation not found'
                ], 404);
            }
            $section = $section->load('metas');
            return response()->json([
                'status' => true,
                'message' => 'Footer Navigation list retrieved successfully',
                'data' => $section,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getFooterNavigation(CmsMeta $navigation)
    {
        try {
            if ($navigation->meta_key !== 'navigation') {
                return response()->json([
                    'status' => false,
                    'message' => 'Footer navigation not found'
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

    function updateFooterNavigation(UpdateNavigationMetaRequest $request, CmsMeta $navigation): JsonResponse
    {
        try {
            if ($navigation?->meta_key !== 'navigation' || $navigation?->cms?->page != 'footer') {
                return response()->json([
                    'status' => false,
                    'message' => 'Footer navigation meta not found'
                ], 404);
            }
            DB::beginTransaction();
            $navigation->update([
                'meta_value' => $request->input('navigation', $navigation?->meta_value),
            ]);
            $metaValue = $navigation->cmsMetaValues()->first();

            if ($metaValue) {
                $metaValue->update([
                    'value' => $request->input('url', $metaValue->value),
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Footer navigation meta updated successfully',
                'data' => $navigation->load('cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
