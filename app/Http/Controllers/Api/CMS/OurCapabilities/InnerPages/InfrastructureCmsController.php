<?php

namespace App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateBannerSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateCaseStudySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateClaritySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateComponentsSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateInfrastructureMattersSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateMatterSectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdatePrioritySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateReliabilitySectionRequest;
use App\Http\Requests\Api\CMS\OurCapabilitiesPageCms\Infrastructure\UpdateServicesSectionRequest;
use App\Models\Cms;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfrastructureCmsController extends Controller
{
    function getMainSectionsList(): JsonResponse
    {
        try {
            $data = Cms::where('page', 'infrastructure')->select('id', 'slug', 'type', 'page')
                // ->with(['metas', 'metas.cmsMetaValues'])
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'Infrastructure Page Sections list retrieved successfully',
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
            if ($section->type == 'Banner Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Banner Section' && $section->page == 'infrastructure') {
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
            if ($section->type == 'Priority Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Priority Section' && $section->page == 'infrastructure') {
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
            if ($section->type == 'Matter Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Matter Section' && $section->page == 'infrastructure') {
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

    function getInfrastructureMattersSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Infrastructure Matters Section'  && $section->page == 'infrastructure') {
                return response()->json([
                    'status' => true,
                    'message' => 'Infrastructure Matters Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Infrastructure Matters Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateInfrastructureMattersSection(UpdateInfrastructureMattersSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Infrastructure Matters Section' && $section->page == 'infrastructure') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Infrastructure Matters Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Infrastructure Matters Section not found'
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
            if ($section->type == 'Services Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Services Section' && $section->page == 'infrastructure') {
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

    function getComponentsSection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Components Section'  && $section->page == 'infrastructure') {
                return response()->json([
                    'status' => true,
                    'message' => 'Components Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Components Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateComponentsSection(UpdateComponentsSectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Components Section' && $section->page == 'infrastructure') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Components Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Components Section not found'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function getReliabilitySection(Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Reliability Section'  && $section->page == 'infrastructure') {
                return response()->json([
                    'status' => true,
                    'message' => 'Reliability Section retrieved successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Reliability Section not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function updateReliabilitySection(UpdateReliabilitySectionRequest $request, Cms $section): JsonResponse
    {
        try {
            if ($section->type == 'Reliability Section' && $section->page == 'infrastructure') {
                DB::beginTransaction();
                // 🔴 delete old metas (cascade handles values)
                $section->metas()->delete();

                // 🔵 recreate metas
                collect($request->sanitizedMeta())
                    ->map(fn($m) => $section->metas()->create($m));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Reliability Section updated successfully',
                    'data' => $section->load(['metas', 'metas.cmsMetaValues'])
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Reliability Section not found'
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
            if ($section->type == 'Case Study Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Case Study Section' && $section->page == 'infrastructure') {
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
            if ($section->type == 'Clearity Section'  && $section->page == 'infrastructure') {
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
            if ($section->type == 'Clearity Section' && $section->page == 'infrastructure') {
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
