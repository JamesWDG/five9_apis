<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermsConditionPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'terms-condition')->with(['metas', 'metas.cmsMetaValues'])->get()->keyBy('slug');
            return response()->json([
                'status' => true,
                'message' => 'Terms & Conditions Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Terms & Conditions page sections'], 400);
        }
    }
}
