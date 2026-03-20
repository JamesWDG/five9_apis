<?php

namespace App\Http\Controllers\Api\CMS\OurCapabilities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateCapabilitiesSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateCardsSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateClaritySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateDeliveryModulesSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateExpertiseSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\UpdateWorkTogatherSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OurCapabilitiesCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'our-capabilities')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'About Us Page Sections list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getInnerPagesList(): JsonResponse
    {
        try {
            $data = ['transformation', 'artificial_intelligence', 'security', 'infrastructure', 'enterprise_applications','applications','data_engineering','cloud'];
            return response()->json([
                'status' => true,
                'message' => 'Our Capabilities Inner Pages list retrieved successfully',
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
            if ($section->type == 'Banner Section'  && $section->page == 'our-capabilities') {
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
            if ($section->type == 'Banner Section' && $section->page == 'our-capabilities') {
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

    function getCapabilitiesSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Capabilities Section'  && $section->page == 'our-capabilities') {
                return response()->json([
                    'status' => true,
                    'message' => 'Capabilities Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Capabilities Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateCapabilitiesSection(UpdateCapabilitiesSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Capabilities Section' && $section->page == 'our-capabilities') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Capabilities Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Capabilities Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getCardsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Cards Section'  && $section->page == 'our-capabilities') {
                $cards = [];
                $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'cards')->first();
                $values = $meta?->cmsMetaValues?->values();
                $temp = null;
                if ($values != null) {

                    foreach ($values as $item) {

                        // 🟢 new card start
                        if ($item->key === '#box_heading') {

                            // previous card complete → push
                            if ($temp) {
                                $cards[] = $temp;
                            }

                            $temp = [
                                'box_heading' => $item->value,
                                'box_image' => null,
                                'box_button_text' => null,
                                'box_button_url' => null,
                                'box_para' => null,
                            ];

                            continue;
                        }

                        // 🟢 fill current card fields
                        if ($temp) {
                            if ($item->key === 'box_image') {
                                $temp['box_image'] = $item->value;
                            }

                            if ($item->key === 'box_para') {
                                $temp['box_para'] = $item->value;
                            }
                            if ($item->key === 'box_button_text') {
                                $temp['box_button_text'] = $item->value;
                            }
                            if ($item->key === 'box_button_url') {
                                $temp['box_button_url'] = $item->value;
                            }
                        }
                    }
                    // 🟢 last card push
                    if ($temp) {
                        $cards[] = $temp;
                    }
                    // crud meta se raw values hata do
                    $meta?->setRelation('cmsMetaValues', collect());
                }


                return response()->json([
                    'status' => true,
                    'message' => 'Cards Section retrieved successfully',
                    'data' => [
                        'id'    => $section->id,
                        'type'  => $section->type,
                        'page'  => $section->page,
                        'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                        'cards' => $cards
                    ]
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Cards Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateCardsSection(UpdateCardsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Cards Section'  && $section->page == 'our-capabilities') {
                DB::transaction(function () use ($request, $section) {

                    // // 🔴 delete old metas (cascade handles values)
                    $section->metas()->delete();
                    // 🔵 recreate metas
                    $metas = collect($request->sanitizedMeta())
                        ->map(fn($m) => $section->metas()->create($m));
                    $crudMeta = $section->metas->firstWhere('meta_key', 'crud');
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
                    'message' => 'Cards Section updated successfully',
                    'data' => $section->fresh()->load('metas.cmsMetaValues')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Cards Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getWorkTogatherSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Work Togather Section'  && $section->page == 'our-capabilities') {
                return response()->json([
                    'status' => true,
                    'message' => 'Work Togather Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Work Togather Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateWorkTogatherSection(UpdateWorkTogatherSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Work Togather Section' && $section->page == 'our-capabilities') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Work Togather Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Work Togather Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getDeliveryModulesSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Delivery Modules Section'  && $section->page == 'our-capabilities') {
                return response()->json([
                    'status' => true,
                    'message' => 'Delivery Modules Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Delivery Modules Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateDeliveryModulesSection(UpdateDeliveryModulesSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Delivery Modules Section' && $section->page == 'our-capabilities') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Delivery Modules Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Delivery Modules Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getExpertiseSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Expertise Section'  && $section->page == 'our-capabilities') {
                return response()->json([
                    'status' => true,
                    'message' => 'Expertise Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Expertise Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateExpertiseSection(UpdateExpertiseSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Expertise Section' && $section->page == 'our-capabilities') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Expertise Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Expertise Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getClaritySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Clearity Section'  && $section->page == 'our-capabilities') {
                return response()->json([
                    'status' => true,
                    'message' => 'Clearity Section retrieved successfully',
                    'data' => $section->load(['metas'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Clearity Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateClaritySection(UpdateClaritySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Clearity Section' && $section->page == 'our-capabilities') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Clearity Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Clearity Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
