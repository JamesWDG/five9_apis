<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateAdvisorySectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateAvailableSectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateBusinessSectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateCapabilitiesSectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateContentSectionRequest;
use App\Http\Requests\Api\CMS\AboutUsPageCms\UpdateWhyChooseUsSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AboutUsPageCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'about-us')->select('id', 'slug', 'type', 'page')
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

    function getBannerSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Banner Section'  && $section->page == 'about-us') {
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
            if ($section->type == 'Banner Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'title') {
                        $meta->update(['meta_value' => $request->input('title')]);
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

    function getContentSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Content Section' && $section->page == 'about-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Content Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Content Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateContentSection(UpdateContentSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Content Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'para') {
                        $meta->update(['meta_value' => $request->input('para')]);
                    } elseif ($meta->meta_key === 'image') {
                        $meta->update(['meta_value' => $request->sanitiazedImage()]);
                    }
                }
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Content Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Content Section not found'
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
            if ($section->type == 'Capabilities Section' && $section->page == 'about-us') {
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
            if ($section->type == 'Capabilities Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading_1') {
                        $meta->update(['meta_value' => $request->input('heading_1')]);
                    } elseif ($meta->meta_key === 'heading_2') {
                        $meta->update(['meta_value' => $request->input('heading_2')]);
                    } elseif ($meta->meta_key === 'heading_3') {
                        $meta->update(['meta_value' => $request->input('heading_3')]);
                    } elseif ($meta->meta_key === 'sub_heading') {
                        $meta->update(['meta_value' => $request->input('sub_heading')]);
                    } elseif ($meta->meta_key === 'para') {
                        $meta->update(['meta_value' => $request->input('para')]);
                    }
                }
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

    function getBusinessSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Business Section' && $section->page == 'about-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Business Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Business Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateBusinessSection(UpdateBusinessSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Business Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'sub_heading') {
                        $meta->update(['meta_value' => $request->input('sub_heading')]);
                    } elseif ($meta->meta_key === 'para') {
                        $meta->update(['meta_value' => $request->input('para')]);
                    } elseif ($meta->meta_key === 'button_text') {
                        $meta->update(['meta_value' => $request->input('button_text')]);
                    } elseif ($meta->meta_key === 'button_url') {
                        $meta->update(['meta_value' => $request->input('button_url')]);
                    }
                }
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Business Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Business Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getWhyChooseUsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Why Choose Us Section' && $section->page == 'about-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Why Choose Us Section retrieved successfully',
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
            if ($section->type == 'Why Choose Us Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'para') {
                        $meta->update(['meta_value' => $request->input('para')]);
                    }
                }
                DB::commit();
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
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getAvailableSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Available Section' && $section->page == 'about-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Available Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Available Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateAvailableSection(UpdateAvailableSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Available Section' && $section->page == 'about-us') {
                DB::beginTransaction();
                foreach ($section->metas as $meta) {
                    if ($meta->meta_key === 'heading') {
                        $meta->update(['meta_value' => $request->input('heading')]);
                    } elseif ($meta->meta_key === 'para') {
                        $meta->update(['meta_value' => $request->input('para')]);
                    }
                }
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Available Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Available Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getAdvisorySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Advisory Section' && $section->page == 'about-us') {
                $cards = [];
                $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'bullets')->first();
                $values = $meta->cmsMetaValues->values();
                $temp = null;

                foreach ($values as $item) {

                    // 🟢 new card start
                    if ($item->key === '#point') {

                        // previous card complete → push
                        if ($temp) {
                            $cards[] = $temp;
                        }

                        $temp = [
                            'point' => $item->value,
                        ];

                        continue;
                    }

                    // 🟢 fill current card fields
                    if ($temp) {
                        if ($item->key === 'point') {
                            $temp['point'] = $item->value;
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
                    'message' => 'Advisory Section retrieved successfully',
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
                'message' => 'Advisory Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateAdvisorySection(UpdateAdvisorySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Advisory Section' && $section->page == 'about-us') {
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
                    'message' => 'Advisory Section updated successfully',
                    'data' => $section->fresh()->load('metas.cmsMetaValues')
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Advisory Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
