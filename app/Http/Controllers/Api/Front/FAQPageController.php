<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $sections = Cms::where('page', 'faq')->with(['metas', 'metas.cmsMetaValues'])->get()->keyBy('slug');

            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Questionary_Section') {

                    $missionSection = $this->getFAQSection($section);

                    // $data['Questionary_Section'] = $missionSection['section'];
                    $data['Questionary_Section']['questions_answers'] = $missionSection['cards'];

                    continue;
                }
                $data[$section->slug] = $section;
            }

            return response()->json([
                'status' => true,
                'message' => 'FAQ Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve FAQ page sections'], 400);
        }
    }

    private function getFAQSection($section)
    {
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
        return [
            // 'section' => $section->setRelation(
            //     'metas',
            //     $section->metas->where('meta_key', '!=', 'crud')->values()
            // ),
            'cards' => $cards
        ];
    }
}
