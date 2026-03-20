<?php

namespace App\Http\Controllers\Api\CMS\OurServices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\OurServicesPageCms\UpdateBannerSectionRequest;
use App\Http\Requests\Api\Cms\OurServicesPageCms\UpdateGetStartedSectionRequest;
use App\Http\Requests\Api\CMS\OurServicesPageCms\UpdateHowWeWorkSectionRequest;
use App\Http\Requests\Api\CMS\OurServicesPageCms\UpdateServiceSectionRequest;
use App\Http\Requests\Api\CMS\OurServicesPageCms\UpdateWhyChooseUsSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OurServicesPageCmsController extends Controller
{

    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'our-services')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Our Services Sections list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getInnerPagesList() : JsonResponse {
        try {
            $data = ['strategy','fractional_cto','digital_services','consulting','advisory'];
            return response()->json([
                'status' => true,
                'message' => 'Our Services Inner Pages list retrieved successfully',
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
            if ($section->type == 'Banner Section'  && $section->page == 'our-services') {
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
            if ($section->type == 'Banner Section' && $section->page == 'our-services') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'sub_heading') {
                        $meta->update(['meta_value' => $request->input('sub_heading')]);
                    }
                }
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


    function getServiceSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Services Section'  && $section->page == 'our-services') {
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
                            'button_text' => null,
                            'button_url' => null,
                            'title_bg_image' => null,
                        ];

                        continue;
                    }

                    // 🟢 fill current card fields
                    if ($temp) {
                        if ($item->key === 'para') {
                            $temp['para'] = $item->value;
                        }

                        if ($item->key === 'button_text') {
                            $temp['button_text'] = $item->value;
                        }

                        if ($item->key === 'button_url') {
                            $temp['button_url'] = $item->value;
                        }

                        if ($item->key === 'title_bg_image') {
                            $temp['title_bg_image'] = $item->value;
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
                    'message' => 'Services Section retrieved successfully',
                    'data' => [
                        'id'    => $section->id,
                        'type'  => $section->type,
                        'page'  => $section->page,
                        // 'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                        'cards' => $cards
                    ]
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Services Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateServiceSection(UpdateServiceSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Services Section'  && $section->page == 'our-services') {
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
                    'message' => 'Services Section updated successfully',
                    'data' => $section->fresh()->load('metas.cmsMetaValues')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Services Section not found'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getHowWeWorkSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'How We Work Section'  && $section->page == 'our-services') {
                // $cards = [];
                // $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'points')->first();
                // $values = $meta->cmsMetaValues->values();
                // $temp = null;

                // foreach ($values as $item) {

                //     // 🟢 new card start
                //     if ($item->key === '#title') {

                //         // previous card complete → push
                //         if ($temp) {
                //             $cards[] = $temp;
                //         }

                //         $temp = [
                //             'title' => $item->value,
                //             'para' => null,
                //         ];

                //         continue;
                //     }

                //     // 🟢 fill current card fields
                //     if ($temp) {
                //         if ($item->key === 'para') {
                //             $temp['para'] = $item->value;
                //         }
                //     }
                // }

                // // 🟢 last card push
                // if ($temp) {
                //     $cards[] = $temp;
                // }

                // // crud meta se raw values hata do
                // $meta->setRelation('cmsMetaValues', collect());

                // return response()->json([
                //     'status' => true,
                //     'message' => 'How We Work Section retrieved successfully',
                //     'data' => [
                //         'id'    => $section->id,
                //         'type'  => $section->type,
                //         'page'  => $section->page,
                //         'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                //         'cards' => $cards
                //     ]
                // ], 200);
                return response()->json([
                    'status' => true,
                    'message' => 'How We Work Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'How We Work Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateHowWeWorkSection(UpdateHowWeWorkSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'How We Work Section'  && $section->page == 'our-services') {
                DB::transaction(function () use ($request, $section) {

                    // 🔴 delete old metas (cascade handles values)
                    $section->metas()->delete();

                    // 🔵 recreate metas
                    collect($request->sanitizedMeta())
                        ->map(fn($m) => $section->metas()->create($m));

                    // $crudMeta = $metas->firstWhere('meta_key', 'crud');

                    // 🔵 create cards values
                    // foreach ($request->sanitizedCards() as $card) {
                    //     foreach ($card as $key => $value) {
                    //         $crudMeta->cmsMetaValues()->create([
                    //             'key' => $key,
                    //             'value' => $value
                    //         ]);
                    //     }
                    // }
                });

                return response()->json([
                    'status' => true,
                    'message' => 'How We Work Section updated successfully',
                    'data' => $section->fresh()->load('metas')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'How We Work Section not found'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getWhyChooseUsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type = 'Why Choose Us Section'  && $section->page == 'our-services') {
                // $cards = [];
                // $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'points')->first();
                // $values = $meta->cmsMetaValues->values();
                // $temp = null;

                // foreach ($values as $item) {

                //     // 🟢 new card start
                //     if ($item->key === '#title') {

                //         // previous card complete → push
                //         if ($temp) {
                //             $cards[] = $temp;
                //         }

                //         $temp = [
                //             'title' => $item->value,
                //             'para' => null,
                //         ];

                //         continue;
                //     }

                //     // 🟢 fill current card fields
                //     if ($temp) {
                //         if ($item->key === 'para') {
                //             $temp['para'] = $item->value;
                //         }
                //     }
                // }

                // // 🟢 last card push
                // if ($temp) {
                //     $cards[] = $temp;
                // }

                // // crud meta se raw values hata do
                // $meta->setRelation('cmsMetaValues', collect());

                // return response()->json([
                //     'status' => true,
                //     'message' => 'Why Choose Us Section retrieved successfully',
                //     'data' => [
                //         'id'    => $section->id,
                //         'type'  => $section->type,
                //         'page'  => $section->page,
                //         'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                //         'cards' => $cards
                //     ]
                // ], 200);

                return response()->json([
                    'status' => true,
                    'message' => 'Why Choose Us Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Why Choose Us Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateWhyChooseUsSection(UpdateWhyChooseUsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Why Choose Us Section'  && $section->page == 'our-services') {
                DB::transaction(function () use ($request, $section) {

                    // 🔴 delete old metas (cascade handles values)
                    $section->metas()->delete();

                    // 🔵 recreate metas
                    $metas = collect($request->sanitizedMeta())
                        ->map(fn($m) => $section->metas()->create($m));

                    // $crudMeta = $metas->firstWhere('meta_key', 'crud');

                    // // 🔵 create cards values
                    // foreach ($request->sanitizedCards() as $card) {
                    //     foreach ($card as $key => $value) {
                    //         $crudMeta->cmsMetaValues()->create([
                    //             'key' => $key,
                    //             'value' => $value
                    //         ]);
                    //     }
                    // }
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Why Choose Us Section updated successfully',
                    'data' => $section->fresh()->load('metas')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Why Choose Us Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getGetStartedSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type = 'Get Started Section'  && $section->page == 'our-services') {

                return response()->json([
                    'status' => true,
                    'message' => 'Why Choose Us Section retrieved successfully',
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
                'message' => 'Why Choose Us Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateGetStartedSection(UpdateGetStartedSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Get Started Section' && $section->page == 'our-services') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Get Started Section updated successfully',
                    'data' => $section->load(['metas'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Get Started Section not found'
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
