<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateAboutUsSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateBlogsSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateCapabilitiesSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateHeroBannerSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateMarqueSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateMissionSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateNewsletterSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateServiceSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateTestimonialSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateVideoBannerSectionRequest;
use App\Http\Requests\Api\CMS\HomePageCms\UpdateWhyChooseUsSectionRequest;
use App\Models\Cms;
use App\Models\CmsMetaValue;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HomePageCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'home')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Home Page CMS list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getHeroBannerSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Hero Banner Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Hero Banner section not found'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Hero Banner section retrieved successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateHeroBannerSection(UpdateHeroBannerSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Hero Banner Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Hero Banner section not found'
                ], 404);
            }
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
                'message' => 'Hero Banner section updated successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    function getVideoBannerSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Hero Video Banner Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Hero Video Banner Section not found'
                ], 404);
            }
            return response()->json([
                'status' => true,
                'message' => 'Hero Video Banner Section retrieved successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateVideoBannerSection(UpdateVideoBannerSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Hero Video Banner Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Hero Video Banner Section not found'
                ], 404);
            }
            $publicUrl = null;
            if ($request->hasFile('video')) {
                // Get uploaded file
                $file = $request->file('video');

                // Create a unique filename
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Move file to public/images/header_logos
                $destinationPath = public_path('videos/hero_video_banner');
                $file->move($destinationPath, $filename);

                // Full public URL
                $publicUrl = asset('videos/hero_video_banner/' . $filename);
            }
            DB::beginTransaction();
            foreach ($section->metas as $meta) {
                if ($meta->meta_key === 'video' && $publicUrl) {
                    $meta->update(['meta_value' => $publicUrl]);
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
                'message' => 'Hero Video Banner section updated successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getMarqueSection(Cms $section): JsonResponse
    {
        try {

            if ($section->type !== 'Marque Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Marque Section not found'
                ], 404);
            }
            $data = $section->load(['metas', 'metas.cmsMetaValues']);
            return response()->json([
                'status' => true,
                'message' => 'Marque Section retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateMarqueSection(UpdateMarqueSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Marque Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Marque Section not found'
                ], 404);
            }

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
                } elseif ($meta->meta_key === 'button_text') {
                    $meta->update(['meta_value' => $request->input('button_text')]);
                } elseif ($meta->meta_key === 'button_url') {
                    $meta->update(['meta_value' => $request->input('button_url')]);
                }
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Marque Section updated successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getAboutUsSection(Cms $section): JsonResponse
    {
        try {

            if ($section->type !== 'About Us Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'About Us Section not found'
                ], 404);
            }
            $data = $section->load(['metas', 'metas.cmsMetaValues']);
            return response()->json([
                'status' => true,
                'message' => 'About Us Section retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateAboutUsSection(UpdateAboutUsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'About Us Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'About Us Section not found'
                ], 404);
            }

            DB::beginTransaction();

            foreach ($section->metas as $meta) {
                if ($meta->meta_key === 'title') {
                    $meta->update(['meta_value' => $request->input('title')]);
                } elseif ($meta->meta_key === 'heading') {
                    $meta->update(['meta_value' => $request->input('heading')]);
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
                'message' => 'About Us Section updated successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getMissionSection(Cms $section): JsonResponse
    {
        try {

            if ($section->type !== 'Mission Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Mission Section not found'
                ], 404);
            }
            $data = $section->load(['metas', 'metas.cmsMetaValues']);
            $cards = [];
            foreach ($data->metas as $meta) {

                $values = $meta->cmsMetaValues->values(); // reset index
                $temp = [];

                foreach ($values as $item) {
                    if ($item->key === '#title') {
                        // naya card start
                        $temp = [
                            'title' => $item->value,
                            'para'  => null
                        ];
                    }

                    if ($item->key === 'para' && !empty($temp)) {
                        $temp['para'] = $item->value;
                        $cards[] = $temp; // complete card push
                        $temp = [];
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Mission Section retrieved successfully',
                'data' => [
                    'id'    => $section->id,
                    'type'  => $section->type,
                    'page'  => $section->page,
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

    public function updateMissionSection(UpdateMissionSectionRequest $request, Cms $section)
    {
        try {
            if ($section->type !== 'Mission Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Mission Section not found'
                ], 404);
            }
            DB::beginTransaction();
            // Delete existing meta values
            $metaId = $section->metas[0]->id;
            $section->metas[0]->cmsMetaValues()->delete();

            // Now, add new meta values from the request
            foreach ($request->sanitized() as $value) {
                foreach ($value as $k => $v) {
                    CmsMetaValue::create([
                        'cms_meta_id' => $metaId,
                        'key' => $k,
                        'value' => $v
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Mission Section updated successfully',
                'data' => $section->load(['metas', 'metas.cmsMetaValues'])
            ], 200);
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
            if ($section->type !== 'Services Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Services Section not found'
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

    public function updateServiceSection(UpdateServiceSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Services Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Services Section not found'
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
                'message' => 'Services Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
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
            if ($section->type != 'Why Choose Us Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Why Choose Us Section not found'
                ], 404);
            }
            $cards = [];
            $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'cards')->first();
            $values = $meta->cmsMetaValues->values();
            $temp = null;

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
                        'box_text' => null,
                    ];

                    continue;
                }

                // 🟢 fill current card fields
                if ($temp) {
                    if ($item->key === 'box_image') {
                        $temp['box_image'] = $item->value;
                    }

                    if ($item->key === 'box_text') {
                        $temp['box_text'] = $item->value;
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
                'message' => 'Why Choose Us Section retrieved successfully',
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

    function updateWhyChooseUsSection(UpdateWhyChooseUsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Why Choose Us Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Why Choose Us Section not found'
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
                'message' => 'Why Choose Us Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getCapabilitiesSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type != 'Capabilities Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Capabilities Section not found'
                ], 404);
            }
            $cards = [];
            $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'cards')->first();
            $values = $meta->cmsMetaValues->values();
            $temp = null;

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
                'message' => 'Capabilities Section retrieved successfully',
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
    public function updateCapabilitiesSection(UpdateCapabilitiesSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Capabilities Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Capabilities Section not found'
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
                'message' => 'Capabilities Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getBlogsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type != 'Blog Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Blog Section not found'
                ], 404);
            }
            $cards = [];
            $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'cards')->first();
            $values = $meta->cmsMetaValues->values();
            $temp = null;

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
                        'box_para' => null,
                        'box_date' => null,
                        'box_button_text' => null,
                        'box_button_url' => null,
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

                    if ($item->key === 'box_date') {
                        $temp['box_date'] = $item->value;
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
            $meta->setRelation('cmsMetaValues', collect());

            return response()->json([
                'status' => true,
                'message' => 'Blog Section retrieved successfully',
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


    public function updateBlogsSection(UpdateBlogsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type !== 'Blog Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Blog Section not found'
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
                'message' => 'Blog Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getTestimonialsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type != 'Testimonials Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Testimonials Section not found'
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
            if ($section->type !== 'Testimonials Section') {
                return response()->json([
                    'status' => false,
                    'message' => 'Testimonials Section not found'
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
                'message' => 'Testimonials Section updated successfully',
                'data' => $section->fresh()->load('metas.cmsMetaValues')
            ], 200);
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


}
