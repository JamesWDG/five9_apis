<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutUsPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {

            $sections = Cms::where('page', 'about-us')
                ->with(['metas', 'metas.cmsMetaValues'])
                ->get();

            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Advisory_Section') {

                    $advisorySection = $this->getAdvisorySection($section);

                    $data['Advisory_Section'] = $advisorySection['section'];
                    $data['Advisory_Section']['cards'] = $advisorySection['cards'];

                    continue;
                }

                $data[$section->slug] = $section;
            }

            return response()->json([
                'status' => true,
                'message' => 'About Us Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve About Us page sections'
            ], 400);
        }
    }
    
    private function getAdvisorySection($section)
    {
        $cards = [];

        $meta = $section->metas
            ->where('meta_key', 'crud')
            ->where('meta_value', 'bullets')
            ->first();

        $values = $meta?->cmsMetaValues?->values();

        if ($values) {

            foreach ($values as $item) {

                if ($item->key === '#point') {

                    $cards[] = [
                        'point' => $item->value
                    ];
                }
            }
        }

        return [
            'section' => $section->setRelation(
                'metas',
                $section->metas->where('meta_key', '!=', 'crud')->values()
            ),
            'cards' => $cards
        ];
    }
}
