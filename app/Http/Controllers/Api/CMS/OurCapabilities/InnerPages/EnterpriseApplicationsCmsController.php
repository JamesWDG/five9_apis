<?php

namespace App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateCaseStudySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateClaritySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateMatterSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdatePrioritySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateServicesSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateTechnologiesWeUseSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\EnterpriseApplications\UpdateWeBuildSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Transformation\UpdateApproachSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EnterpriseApplicationsCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'enterprise-applications')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Enterprise-Applications Page Sections list retrieved successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getBannerSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Banner Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Banner section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Banner section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateBannerSection(UpdateBannerSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Banner Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Banner section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Banner section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getPrioritySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Priority Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Priority section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Priority section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updatePrioritySection(UpdatePrioritySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Priority Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Priority Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Priority Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getMatterSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Matter Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Matter section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Matter section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateMatterSection(UpdateMatterSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Matter Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Matter Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Matter Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getServicesSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Services Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Services Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Services Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateServicesSection(UpdateServicesSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Services Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Services Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Services Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getApproachSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Approach Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Approach Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Approach Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateApproachSection(UpdateApproachSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Approach Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Approach Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Approach Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getWeBuildSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'We Build Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'We Build Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'We Build Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateWeBuildSection(UpdateWeBuildSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'We Build Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'We Build Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'We Build Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getTechnologiesWeUseSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Technologies We Use Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Technologies We Use Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Technologies We Use Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateTechnologiesWeUseSection(UpdateTechnologiesWeUseSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Technologies We Use Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Technologies We Use Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Technologies We Use Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getCaseStudySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Case Study Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Case Study Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Case Study Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateCaseStudySection(UpdateCaseStudySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Case Study Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Case Study Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Case Study Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    function getClaritySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Clearity Section'  && $section->page == 'enterprise-applications') {
                return response()->json([
                    'status' => true,
                    'message' => 'Clearity Section retrieved successfully',
                    'data' => $section->load(['metas'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Clearity Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateClaritySection(UpdateClaritySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Clearity Section' && $section->page == 'enterprise-applications') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Clearity Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Clearity Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
