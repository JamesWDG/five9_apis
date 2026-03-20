<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateClientSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateContactUsSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateFAQSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateLetTalkSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateLinksSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateTaglineSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateTalkToUsSectionRequest;
use App\Http\Requests\Api\CMS\ContactUsPageCms\UpdateWhatHappensNextSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContactUsPageCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'contact-us')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Contact Us Page Sections list retrieved successfully',
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
            if ($section->type == 'Banner Section'  && $section->page == 'contact-us') {
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
            if ($section->type == 'Banner Section' && $section->page == 'contact-us') {
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

    function getTaglineSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Tagline Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Tagline section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Tagline section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateTaglineSection(UpdateTaglineSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Tagline Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Tagline section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Tagline section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getTalkToUsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Talk To Us Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Talk To Us Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Talk To Us Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateTalkToUsSection(UpdateTalkToUsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Talk To Us Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Talk To Us Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Talk To Us Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getContactUsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Contact Us Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Contact Us Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Contact Us Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateContactUsSection(UpdateContactUsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Contact Us Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Contact Us Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Contact Us Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getClientSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Client Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Client Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Client Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateClientSection(UpdateClientSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Client Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Client Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Client Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    function getWhatHappensNextSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'What Happens Next Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'What Happens Next Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'What Happens Next Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateWhatHappensNextSection(UpdateWhatHappensNextSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'What Happens Next Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'What Happens Next Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'What Happens Next Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getLetTalkSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Let Talk Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Let Talk Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Let Talk Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateLetTalkSection(UpdateLetTalkSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Let Talk Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Let Talk Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Let Talk Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getLinksSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Links Section'  && $section->page == 'contact-us') {
                return response()->json([
                    'status' => true,
                    'message' => 'Links Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Links Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateLinksSection(UpdateLinksSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Links Section' && $section->page == 'contact-us') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Links Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Links Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getFAQSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'FAQ Section'  && $section->page == 'contact-us') {
                $cards = [];
                $meta = $section->metas->where('meta_key', 'crud')->where('meta_value', 'questions-answers')->first();
                $values = $meta?->cmsMetaValues?->values();
                $temp = null;
                if ($values != null) {

                    foreach ($values as $item) {

                        // 🟢 new card start
                        if ($item->key === '#question') {

                            // previous card complete → push
                            if ($temp) {
                                $cards[] = $temp;
                            }

                            $temp = [
                                'question' => $item->value,
                                'answer' => null,
                            ];

                            continue;
                        }

                        // 🟢 fill current card fields
                        if ($temp) {
                            if ($item->key === 'answer') {
                                $temp['answer'] = $item->value;
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
                        'questions_answers' => $cards
                    ]
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'FAQ Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateFAQSection(UpdateFAQSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'FAQ Section' && $section->page == 'contact-us') {
                DB::transaction(function () use ($request, $section) {

                    // // 🔴 delete old metas (cascade handles values)
                    $section->metas()->delete();
                    // 🔵 recreate metas
                    $metas = collect($request->sanitizedMeta())
                        ->map(fn($m) => $section->metas()->create($m));
                    $crudMeta = $section->metas->firstWhere('meta_key', 'crud');
                    // 🔵 create cards values
                    foreach ($request->sanitizedQuestionsAnswers() as $card) {
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
                    'message' => 'FAQ Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'FAQ Section not found'
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
