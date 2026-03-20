<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;

class HomePageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {

            $sections = Cms::where('page', 'home')
                ->with(['metas', 'metas.cmsMetaValues'])
                ->get();

            $data = [];

            foreach ($sections as $section) {

                if ($section->slug === 'Mission_Section') {

                    $missionSection = $this->getMissionSection($section);

                    $data['Mission_Section'] = $missionSection['section'];
                    $data['Mission_Section']['cards'] = $missionSection['cards'];

                    continue;
                }
                if ($section->slug === 'Service_Section') {

                    $servicesSection = $this->getServicesSection($section);

                    $data['Service_Section'] = $servicesSection['section'];
                    $data['Service_Section']['cards'] = $servicesSection['cards'];

                    continue;
                }
                if ($section->slug === 'Why_Choose_Us_Section') {
                    $whyChooseUsSection = $this->getWhyChooseUsSection($section);

                    $data['Why_Choose_Us_Section'] = $whyChooseUsSection['section'];
                    $data['Why_Choose_Us_Section']['cards'] = $whyChooseUsSection['cards'];

                    continue;
                }
                if ($section->slug === 'Capabilities_Section') {
                    $capabilitiesSection = $this->getCapabilitiesSection($section);

                    $data['Capabilities_Section'] = $capabilitiesSection['section'];
                    $data['Capabilities_Section']['cards'] = $capabilitiesSection['cards'];

                    continue;
                }

                $data[$section->slug] = $section;
            }
            $blogs = Blog::select('id', 'title', 'short_description', 'featured_image', 'date')->latest()->take(5)->get();
            $data['blogs'] = $blogs;

            return response()->json([
                'status' => true,
                'message' => 'Home Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Home page sections'], 400);
        }
    }

    private function getMissionSection($section)
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
                    ];

                    continue;
                }

                if ($temp && $item->key === 'para') {
                    $temp['para'] = $item->value;
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
    private function getWhyChooseUsSection($section)
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
                        'box_text' => null,
                        'box_image' => null,
                    ];

                    continue;
                }

                if ($temp && $item->key === 'box_heading') {
                    $temp['box_heading'] = $item->value;
                }
                if ($temp && $item->key === 'box_text') {
                    $temp['box_text'] = $item->value;
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

        return [
            'section' => $section->setRelation(
                'metas',
                $section->metas->where('meta_key', '!=', 'crud')->values()
            ),
            'cards' => $cards
        ];
    }
    private function getCapabilitiesSection($section)
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
                        'box_image' => null,
                    ];

                    continue;
                }

                if ($temp && $item->key === 'box_heading') {
                    $temp['box_heading'] = $item->value;
                }
                if ($temp && $item->key === 'box_para') {
                    $temp['box_para'] = $item->value;
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

        return [
            'section' => $section->setRelation(
                'metas',
                $section->metas->where('meta_key', '!=', 'crud')->values()
            ),
            'cards' => $cards
        ];
    }
}
