<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SoloSectionsController extends Controller
{
    function getHeaderFooterSoloSections(): JsonResponse
    {
        try {
            $sections = Cms::whereIn('page', ['Header', 'footer', 'solo'])->with(['metas', 'metas.cmsMetaValues'])->get();
            // ->keyBy('slug');
            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Testimonials_Section') {

                    $testimonialsSection = $this->getTestimonialsSection($section);

                    $data['Testimonials_Section'] = $testimonialsSection['section'];
                    $data['Testimonials_Section']['cards'] = $testimonialsSection['cards'];

                    continue;
                }
                if ($section->slug === 'Footer_Section') {

                    $footerSection = $this->getFooterSection($section);

                    $data['Footer_Section'] = $footerSection['section'];
                    $data['Footer_Section']['cards'] = $footerSection['cards'];

                    continue;
                }
                $data[$section->slug] = $section;
            }
            return response()->json([
                'status' => true,
                'message' => 'Settings retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve settings'], 400);
        }
    }
    private function getTestimonialsSection($section)
    {
        $cards = [];

        $meta = $section->metas
            ->where('meta_key', 'crud')
            ->where('meta_value', 'cards')
            ->first();

        $values = $meta?->cmsMetaValues?->values();

        $temp = null;

        if ($values) {

            foreach ($values as $item) {

                if ($item->key === '#title') {

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

                if ($temp && $item->key === 'para') {
                    $temp['para'] = $item->value;
                }
                if ($temp && $item->key === 'client_name') {
                    $temp['client_name'] = $item->value;
                }
                if ($temp && $item->key === 'client_designation') {
                    $temp['client_designation'] = $item->value;
                }
                if ($temp && $item->key === 'client_company_name') {
                    $temp['client_company_name'] = $item->value;
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

    private function getFooterSection($section)
    {
        $cards = [];

        $meta = $section->metas
            ->where('meta_key', 'crud')
            ->where('meta_value', 'cards')
            ->first();

        $values = $meta?->cmsMetaValues?->values();

        $temp = null;

        if ($values) {

            foreach ($values as $item) {

                if ($item->key === '#title') {

                    if ($temp) {
                        $cards[] = $temp;
                    }

                    $temp = [
                        'title' => $item->value,
                        'info_1' => null,
                        'info_2' => null,
                    ];

                    continue;
                }

                if ($temp && $item->key === 'info_1') {
                    $temp['info_1'] = $item->value;
                }
                if ($temp && $item->key === 'info_2') {
                    $temp['info_2'] = $item->value;
                }
            }

            if ($temp) {
                $cards[] = $temp;
            }

            // $meta?->unSetRelation('cmsMetaValues', collect());
        }
        // dd($cards,$section);

        return [
            'section' => $section->setRelation(
                'metas',
                $section->metas->where('meta_key', '!=', 'crud')->values()
            ),
            'cards' => $cards
        ];
    }
}
