<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateNewsletterSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateTestimonialSectionRequest;
use App\Http\Requests\Api\CMS\MarqueTaglineCms\UpdateMarqueTaglineSectionRequest;
use App\Http\Requests\Api\CMS\SocialLinksCms\UpdateSocialLinksRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SoloSectionsCmsController extends Controller
{

    function getMainSectionsList(): JsonResponse
    {

        try {
            $sections = Cms::where('page', 'solo')->get();
            return response()->json([
                'status' => true,
                'message' => 'Solo Sections list retrieved successfully',
                'data' => $sections
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getTestimonialsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Testimonials Section' && $section->page == 'solo') {
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
                            'para' => null,
                            'client_name' => null,
                            'client_designation' => null,
                            'client_company_name' => null,
                        ];

                        continue;
                    }

                    // 🟢 fill current card fields
                    if ($temp) {
                        if ($item->key === 'para') {
                            $temp['para'] = $item->value;
                        }

                        if ($item->key === 'client_name') {
                            $temp['client_name'] = $item->value;
                        }

                        if ($item->key === 'client_designation') {
                            $temp['client_designation'] = $item->value;
                        }

                        if ($item->key === 'client_company_name') {
                            $temp['client_company_name'] = $item->value;
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
            }
            return response()->json([
                'status' => false,
                'message' => 'Testimonials Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateTestimonialsSection(UpdateTestimonialSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Testimonials Section' && $section->page == 'solo') {
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
                    'message' => 'Testimonials Section updated successfully',
                    'data' => $section->fresh()->load('metas.cmsMetaValues')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Testimonials Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getNewslettersSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type != 'Newsletter Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Newsletter Section not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Newsletter Section retrieved successfully',
                'data' => [
                    'id'    => $section->id,
                    'type'  => $section->type,
                    'page'  => $section->page,
                    'metas' => $section->metas,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function updateNewslettersSection(UpdateNewsletterSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Newsletter Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Newsletter Section not found'
                ], 404);
            }

            DB::transaction(function () use ($request, $section) {

                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                $section->metas()->create($request->sanitized());
            });

            return response()->json([
                'status' => true,
                'message' => 'Newsletter Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getMarqueTagLineSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Marque Tagline Section' && $section->page == 'solo') {
                return response()->json([
                    'status' => true,
                    'message' => 'Marque Tagline Section retrieved successfully',
                    'data' => [
                        'id'    => $section->id,
                        'type'  => $section->type,
                        'page'  => $section->page,
                        'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                    ]
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Marque Tagline Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateMarqueTagLineSection(UpdateMarqueTaglineSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Marque Tagline Section' && $section->page == 'solo') {
                DB::transaction(function () use ($request, $section) {

                    // 🔴 delete old metas (cascade handles values)
                    $section->metas()->delete();

                    // 🔵 recreate metas
                    collect($request->sanitized())
                        ->map(fn($m) => $section->metas()->create($m));
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Marque Tagline Section updated successfully',
                    'data' => $section->fresh()->load('metas')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Marque Tagline Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getSocialLinksSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Social Links Section'  && $section->page == 'solo') {
                return response()->json([
                    'status' => true,
                    'message' => 'Social Links Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Social Links Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateSocialLinksSection(UpdateSocialLinksRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Social Links Section' && $section->page == 'solo') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Social Links Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Social Links Section not found'
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
