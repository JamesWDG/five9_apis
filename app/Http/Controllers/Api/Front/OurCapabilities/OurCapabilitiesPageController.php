<?php

namespace App\Http\Controllers\Api\Front\OurCapabilities;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OurCapabilitiesPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $sections = Cms::where('page', 'our-capabilities')->with(['metas', 'metas.cmsMetaValues'])->get();
            // ->keyBy('slug');

            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Cards_Section') {

                    $servicesSection = $this->getCardsSection($section);

                    $data['Cards_Section'] = $servicesSection['section'];
                    $data['Cards_Section']['cards'] = $servicesSection['cards'];

                    continue;
                }

                $data[$section->slug] = $section;
            }
            return response()->json([
                'status' => true,
                'message' => 'Our Capabilities Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Our Capabilities page sections'], 400);
        }
    }

    private function getCardsSection($section)
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

                if ($item->key === '#box_heading') {

                    if ($temp) {
                        $cards[] = $temp;
                    }

                    $temp = [
                        'box_heading' => $item->value,
                        'box_para' => null,
                        'box_button_text' => null,
                        'box_button_url' => null,
                        'box_image' => null,
                    ];

                    continue;
                }

                if ($temp && $item->key === 'box_para') {
                    $temp['box_para'] = $item->value;
                }
                if ($temp && $item->key === 'box_button_text') {
                    $temp['box_button_text'] = $item->value;
                }
                if ($temp && $item->key === 'box_button_url') {
                    $temp['box_button_url'] = $item->value;
                }
                if ($temp && $item->key === 'box_image') {
                    $temp['box_image'] = $item->value;
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
