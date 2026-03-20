<?php

namespace App\Http\Controllers\Api\Front\OurServices;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;

class OurServicesPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $sections = Cms::where('page', 'our-services')->with(['metas', 'metas.cmsMetaValues'])->get();
            // ->keyBy('slug');
            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Service_Section') {

                    $servicesSection = $this->getServicesSection($section);

                    $data['Service_Section'] = $servicesSection['section'];
                    $data['Service_Section']['cards'] = $servicesSection['cards'];

                    continue;
                }

                $data[$section->slug] = $section;
            }
            return response()->json([
                'status' => true,
                'message' => 'Our Services Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Our Services page sections'], 400);
        }
    }

    private function getServicesSection($section)
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
                        'button_text' => null,
                        'button_url' => null,
                        'title_bg_image' => null,
                    ];

                    continue;
                }

                if ($temp && $item->key === 'para') {
                    $temp['para'] = $item->value;
                }
                if ($temp && $item->key === 'button_text') {
                    $temp['button_text'] = $item->value;
                }
                if ($temp && $item->key === 'button_url') {
                    $temp['button_url'] = $item->value;
                }
                if ($temp && $item->key === 'title_bg_image') {
                    $temp['title_bg_image'] = $item->value;
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
