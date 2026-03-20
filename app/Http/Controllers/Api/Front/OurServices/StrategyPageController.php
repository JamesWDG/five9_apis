<?php

namespace App\Http\Controllers\Api\Front\OurServices;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StrategyPageController extends Controller
{
    public function getSections(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'strategy')->with(['metas', 'metas.cmsMetaValues'])->get()->keyBy('slug');
            return response()->json([
                'status' => true,
                'message' => 'Strategy Page Sections retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Strategy page sections'], 400);
        }
    }
}
