<?php

namespace App\Http\Controllers\Api\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\APi\CMS\FAQPageCms\StoreQuestionarySectionRequest;
use App\Http\Requests\APi\CMS\FAQPageCms\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\FAQPageCms\UpdateClaritySectionRequest;
use App\Http\Requests\APi\CMS\FAQPageCms\UpdateContentSectionRequest;
use App\Http\Requests\Api\CMS\FAQPageCms\UpdateQuestionarySectionRequest;
use App\Models\Cms;
use App\Models\CmsMeta;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FAQPageCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'faq')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'FAQ Page Sections list retrieved successfully',
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
            if ($section->type == 'Banner Section'  && $section->page == 'faq') {
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
            if ($section->type == 'Banner Section' && $section->page == 'faq') {
                DB::beginTransaction();
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

    function getContentSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Content Section'  && $section->page == 'faq') {
                return response()->json([
                    'status' => true,
                    'message' => 'Content section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Content section not found'
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
            if ($section->type == 'Content Section' && $section->page == 'faq') {
                DB::beginTransaction();
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Content section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Content section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getQuestionarySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Questionary Section'  && $section->page == 'faq') {
                $cards = [];

                foreach ($section->metas as $meta) {

                    $values = $meta?->cmsMetaValues?->values();
                    $temp = null;

                    if ($values) {

                        foreach ($values as $item) {

                            // new question start
                            if ($item->key === '#question') {

                                if ($temp) {
                                    $cards[$meta->meta_value][] = $temp;
                                }

                                $temp = [
                                    'question' => $item->value,
                                    'answer' => null,
                                ];

                                continue;
                            }

                            if ($temp && $item->key === 'answer') {
                                $temp['answer'] = $item->value;
                            }
                        }

                        // push last card
                        if ($temp) {
                            $cards[$meta->meta_value][] = $temp;
                        }

                        $meta?->setRelation('cmsMetaValues', collect());
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Cards Section retrieved successfully',
                    'data' => [
                        'id'    => $section->id,
                        'type'  => $section->type,
                        'page'  => $section->page,
                        // 'metas' => $section->metas->where('meta_key', '!=', 'crud')->values(),
                        'questions_answers' => $cards
                    ]
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Questionary section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function storeQuestionarySection(StoreQuestionarySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Questionary Section' && $section->page == 'faq') {
                DB::transaction(function () use ($request, $section) {

                    // // 🔴 delete old metas (cascade handles values)
                    // $section->metas()->delete();
                    // 🔵 recreate metas
                    $metas = collect($request->sanitizedMeta())
                        ->map(fn($m) => $section->metas()->create($m));
                    $crudMeta = $section->metas->firstWhere('meta_value', $request->input('heading'));
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

    function updateQuestionarySection(UpdateQuestionarySectionRequest $request, Cms $cms): JsonResponse
    {
        try {

            if ($cms->type == 'Questionary Section' && $cms->page == 'faq') {

                $section = $cms;

                DB::transaction(function () use ($request, $cms) {

                    // delete old metas
                    $cms->metas()->delete();

                    foreach ($request->sanitizedMeta() as $metaData) {

                        // question list alag nikal lo
                        $questions = $metaData['question-answers'] ?? [];

                        unset($metaData['question-answers']);

                        // create heading meta
                        $meta = $cms->metas()->create($metaData);

                        // insert questions
                        foreach ($questions as $qa) {

                            $meta->cmsMetaValues()->create([
                                'key' => '#question',
                                'value' => $qa['question']
                            ]);

                            $meta->cmsMetaValues()->create([
                                'key' => 'answer',
                                'value' => $qa['answer']
                            ]);
                        }
                    }
                });

                return response()->json([
                    'status' => true,
                    'message' => 'FAQ Section updated successfully',
                    'data' => $cms->load('metas.cmsMetaValues')
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

    function getClaritySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Clearity Section'  && $section->page == 'faq') {
                return response()->json([
                    'status' => true,
                    'message' => 'Clearity Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Clarity section Not Found',
            ], 400);
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
            if ($section->type == 'Clearity Section' && $section->page == 'faq') {
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
