<?php

namespace App\Http\Controllers\Api\Front\OurCapabilities;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;

class SecurityPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'security')->with(['metas', 'metas.cmsMetaValues'])->get()->keyBy('slug');
            return response()->json([
                'status' => true,
                'message' => 'Security Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Security page sections'], 400);
        }
    }
}
