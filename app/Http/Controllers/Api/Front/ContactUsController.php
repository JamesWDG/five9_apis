<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Front\ContactUs\StoreRequest;
use App\Mail\ContactUs;
use App\Models\Cms;
use App\Models\Newsletter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $sections = Cms::where('page', 'contact-us')
                ->with(['metas', 'metas.cmsMetaValues'])
                ->get();

            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'FAQ_Section') {

                    $missionSection = $this->getFAQSection($section);

                    $data['FAQ_Section'] = $missionSection['section'];
                    $data['FAQ_Section']['questions-answers'] = $missionSection['cards'];

                    continue;
                }
                $data[$section->slug] = $section;
            }

            return response()->json([
                'status' => true,
                'message' => 'Contact Us Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'error' => 'Failed to retrieve Contact Us page sections'
            ], 400);
        }
    }

    private function getFAQSection($section)
    {
        $cards = [];

        $meta = $section->metas
            ->where('meta_key', 'crud')
            ->where('meta_value', 'questions-answers')
            ->first();

        $values = $meta?->cmsMetaValues?->values();

        $temp = null;

        if ($values) {

            foreach ($values as $item) {

                if ($item->key === '#question') {

                    if ($temp) {
                        $cards[] = $temp;
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

            if ($temp) {
                $cards[] = $temp;
            }

            // $meta?->unSetRelation('cmsMetaValues', collect());
        }
        return [
            'section' => $section->setRelation(
                'metas',
                $section->metas->where('meta_key', '!=', 'crud')->values()
            ),
            'cards' => $cards
        ];
    }

    function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Newsletter::create($request->sanitized());
            DB::commit();

            Mail::to($request?->email)->send(new ContactUs($request->sanitized()));
            return response()->json([
                'status' => true,
                'message' => 'successfull !',
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
