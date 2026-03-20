<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrivacyPolicyPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'privacy-policy')->with(['metas', 'metas.cmsMetaValues'])->get()->keyBy('slug');
            return response()->json([
                'status' => true,
                'message' => 'Privacy Policy Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Privacy Policy page sections'], 400);
        }
    }
}
