<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\CMS\AboutUsPageCmsController;
use App\Http\Controllers\Api\CMS\BlogsPageCmsController;
use App\Http\Controllers\Api\CMS\ContactUsPageCmsController;
use App\Http\Controllers\Api\CMS\FAQPageCmsController;
use App\Http\Controllers\Api\CMS\FooterCmsSectionController;
use App\Http\Controllers\Api\CMS\HeaderCmsController;
use App\Http\Controllers\Api\CMS\HomePageCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\ApplicationsCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\ArtificialIntelligenceCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\CloudCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\DataEngineeringCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\EnterpriseApplicationsCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\InfrastructureCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\SecurityCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\InnerPages\TransformationCmsController;
use App\Http\Controllers\Api\CMS\OurCapabilities\OurCapabilitiesCmsController;
use App\Http\Controllers\Api\CMS\OurServices\InnerPages\AdvisoryCmsController;
use App\Http\Controllers\Api\CMS\OurServices\InnerPages\ConsultingCmsController;
use App\Http\Controllers\Api\CMS\OurServices\InnerPages\DigitalServicesCmsController;
use App\Http\Controllers\Api\CMS\OurServices\InnerPages\FractionalCTOCmsController;
use App\Http\Controllers\Api\CMS\OurServices\InnerPages\StrategyPageCmsController;
use App\Http\Controllers\Api\CMS\OurServices\OurServicesPageCmsController;
use App\Http\Controllers\Api\CMS\PrivacyPolicyPageCmsController;
use App\Http\Controllers\Api\CMS\SoloSectionsCmsController;
use App\Http\Controllers\Api\CMS\TermsConditionPageCmsController;
use App\Http\Controllers\Api\Front\AboutUsPageController;
use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\FAQPageController;
use App\Http\Controllers\Api\Front\HomePageController;
use App\Http\Controllers\Api\Front\NewsletterController;
use App\Http\Controllers\Api\Front\OurCapabilities\ApplicationsPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\ArtificialIntelligencePageController;
use App\Http\Controllers\Api\Front\OurCapabilities\CloudPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\DataEngineeringPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\EnterpriseApplicationsPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\InfrastructurePageController;
use App\Http\Controllers\Api\Front\OurCapabilities\OurCapabilitiesPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\SecurityPageController;
use App\Http\Controllers\Api\Front\OurCapabilities\TransformationPageController;
use App\Http\Controllers\Api\Front\OurServices\AdvisoryPageController;
use App\Http\Controllers\Api\Front\OurServices\ConsultingPageController;
use App\Http\Controllers\Api\Front\OurServices\DigitalServicesPageController;
use App\Http\Controllers\Api\Front\OurServices\FractionalCTOPageController;
use App\Http\Controllers\Api\Front\OurServices\OurServicesPageController;
use App\Http\Controllers\Api\Front\OurServices\StrategyPageController;
use App\Http\Controllers\Api\Front\PrivacyPolicyPageController;
use App\Http\Controllers\Api\Front\SoloSectionsController;
use App\Http\Controllers\Api\Front\TermsConditionPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    Route::post('reset-password', [ResetPasswordController::class, 'reset']);
});

// Front Pages Fetch/Store Apis

Route::prefix('/front')->group(function () {

    // Store Newsletter Queries
    Route::prefix('/newsletter')->controller(NewsletterController::class)->group(function () {
        Route::post('/store', 'store');
        // Route::get('/sections', 'getSections');
    });
    // Store Contact Us Queries
    Route::prefix('/contact-us')->controller(ContactUsController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/sections', 'getSections');
    });

    // Header Footer Solo Sections
    Route::controller(SoloSectionsController::class)->group(function () {
        Route::get('/solo/sections', 'getHeaderFooterSoloSections');
    });

    // Home page sections
    Route::controller(HomePageController::class)->group(function () {
        Route::get('/home/sections', 'getSections');
    });

    // About Us sections
    Route::controller(AboutUsPageController::class)->group(function () {
        Route::get('/about-us/sections', 'getSections');
    });

    // Our Services sections
    Route::prefix('/our-services')->controller(OurServicesPageController::class)->group(function () {
        Route::get('/sections', 'getSections');

        // Strategy Page sections
        Route::get('/strategy/sections', [StrategyPageController::class, 'getSections']);

        // Fractional CTO Page sections
        Route::get('/fractional-cto/sections', [FractionalCTOPageController::class, 'getSections']);

        // Digital Services Page sections
        Route::get('/digital-services/sections', [DigitalServicesPageController::class, 'getSections']);

        // Consulting Page sections
        Route::get('/consulting/sections', [ConsultingPageController::class, 'getSections']);

        // Advisory Page sections
        Route::get('/advisory/sections', [AdvisoryPageController::class, 'getSections']);
    });

    // Our capabilities sections
    Route::prefix('/our-capabilities')->controller(OurCapabilitiesPageController::class)->group(function () {
        Route::get('/sections', 'getSections');

        // Transformation Page sections
        Route::get('/transformation/sections', [TransformationPageController::class, 'getSections']);

        // Artificial-intelligence Page sections
        Route::get('/artificial-intelligence/sections', [ArtificialIntelligencePageController::class, 'getSections']);

        // security Page sections
        Route::get('/security/sections', [SecurityPageController::class, 'getSections']);

        // Infrastructure Page sections
        Route::get('/infrastructure/sections', [InfrastructurePageController::class, 'getSections']);

        // Enterprise-Applications Page sections
        Route::get('/enterprise-applications/sections', [EnterpriseApplicationsPageController::class, 'getSections']);

        // Applications Page sections
        Route::get('/applications/sections', [ApplicationsPageController::class, 'getSections']);

        // Data-Engineering Page sections
        Route::get('/data-engineering/sections', [DataEngineeringPageController::class, 'getSections']);

        // Cloud Page sections
        Route::get('/cloud/sections', [CloudPageController::class, 'getSections']);
    });

    // Privacy Policy Page sections
    Route::prefix('/privacy-policy')->controller(PrivacyPolicyPageController::class)->group(function () {
        Route::get('/sections', 'getSections');
    });

    // Terms & Condition Page sections
    Route::prefix('/terms-condition')->controller(TermsConditionPageController::class)->group(function () {
        Route::get('/sections', 'getSections');
    });

    // FAQ Page sections
    Route::prefix('/faq')->controller(FAQPageController::class)->group(function () {
        Route::get('/sections', 'getSections');
    });
});

// Dashboard Cms Settings Apis
Route::prefix('/dashboard/cms')->group(function () {
    Route::prefix('/header')->controller(HeaderCmsController::class)->group(function () {
        Route::get('/main-list', 'headerMainList');

        Route::get('/navigations-list/{headerNavigation}', 'headerNavigationsList');
        Route::get('/navigation/{navigation}', 'getHeaderNavigation');
        Route::get('/child-navigation/{childNavigations}', 'getChildNavigation');

        Route::post('/update-navigation-meta/{headerNavigationMeta}', 'updateNavigationMetaValue');
        Route::post('/update-child-navigation-meta/{childMetaValue}', 'updateChildNavigationMetaValue');

        Route::post('/update-logo/{headerLogo}', 'updateLogo');

        Route::get('/getHeaderButton/{headerButton}', 'getHeaderButton');
        Route::post('/update-header-button/{headerButton}', 'updateHeaderButton');
    });
    // Home Page
    Route::prefix('/home-page')->controller(HomePageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // hero Banner Section
        Route::get('/Hero_Banner_Section/{section}', 'getHeroBannerSection');
        Route::post('/Hero_Banner_Section/{section}', 'updateHeroBannerSection');

        // Video Banner Section
        Route::get('/Hero_Video_Banner_Section/{section}', 'getVideoBannerSection');
        Route::post('/Hero_Video_Banner_Section/{section}', 'updateVideoBannerSection');

        // Marque Section
        Route::get('/Marque_Section/{section}', 'getMarqueSection');
        Route::post('/Marque_Section/{section}', 'updateMarqueSection');

        // About US Section
        Route::get('/About_Us_Section/{section}', 'getAboutUsSection');
        Route::post('/About_Us_Section/{section}', 'updateAboutUsSection');

        // Mission Section
        Route::get('/Mission_Section/{section}', 'getMissionSection');
        Route::post('/Mission_Section/{section}', 'updateMissionSection');

        // Services Section
        Route::get('/Services_Section/{section}', 'getServiceSection');
        Route::post('/Services_Section/{section}', 'updateServiceSection');

        // Why Choose Us Section
        Route::get('/Why_Choose_Us_Section/{section}', 'getWhyChooseUsSection');
        Route::post('/Why_Choose_Us_Section/{section}', 'updateWhyChooseUsSection');

        // Capabilities Section
        Route::get('/Capabilities_Section/{section}', 'getCapabilitiesSection');
        Route::post('/Capabilities_Section/{section}', 'updateCapabilitiesSection');

        // Blog Section
        Route::get('/Blog_Section/{section}', 'getBlogsSection');
        Route::post('/Blog_Section/{section}', 'updateBlogsSection');
    });
    // Services Page
    Route::prefix('/our-services-page')->controller(OurServicesPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        Route::get('/inner-pages', 'getInnerPagesList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Services Section
        Route::get('/Services_Section/{section}', 'getServiceSection');
        Route::post('/Services_Section/{section}', 'updateServiceSection');

        // How We Work Section
        Route::get('/How_We_Work_Section/{section}', 'getHowWeWorkSection');
        Route::post('/How_We_Work_Section/{section}', 'updateHowWeWorkSection');

        // Why Choose Us Section
        Route::get('/Why_Choose_Us_Section/{section}', 'getWhyChooseUsSection');
        Route::post('/Why_Choose_Us_Section/{section}', 'updateWhyChooseUsSection');

        // Why Choose Us Section
        Route::get('/Get_Started_Section/{section}', 'getGetStartedSection');
        Route::post('/Get_Started_Section/{section}', 'updateGetStartedSection');

        // Strategy Page
        Route::prefix('/strategy-page')->controller(StrategyPageCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Development Process Section
            Route::get('/Development_Process_Section/{section}', 'getDevelopmentProcessSection');
            Route::post('/Development_Process_Section/{section}', 'updateDevelopmentProcessSection');

            // Focus Areas Section
            Route::get('/Focus_Areas_Section/{section}', 'getFocusAreasSection');
            Route::post('/Focus_Areas_Section/{section}', 'updateFocusAreasSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Fractional CTO Page
        Route::prefix('/fractional-cto-page')->controller(FractionalCTOCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Needs Section
            Route::get('/Needs_Section/{section}', 'getNeedsSection');
            Route::post('/Needs_Section/{section}', 'updateNeedsSection');

            // Engagement Models Section
            Route::get('/Engagement_Models_Section/{section}', 'getEngagementModelsSection');
            Route::post('/Engagement_Models_Section/{section}', 'updateEngagementModelsSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Deliver Section
            Route::get('/Deliver_Section/{section}', 'getDeliverSection');
            Route::post('/Deliver_Section/{section}', 'updateDeliverSection');

            // Backgrounds Section
            Route::get('/Backgrounds_Section/{section}', 'getBackgroundsSection');
            Route::post('/Backgrounds_Section/{section}', 'updateBackgroundsSection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Digital Services Page
        Route::prefix('/digital-services-page')->controller(DigitalServicesCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Area Section
            Route::get('/Area_Section/{section}', 'getAreaSection');
            Route::post('/Area_Section/{section}', 'updateAreaSection');

            // Process Section
            Route::get('/Process_Section/{section}', 'getProcessSection');
            Route::post('/Process_Section/{section}', 'updateProcessSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Consulting Page
        Route::prefix('/consulting-page')->controller(ConsultingCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Engagement Type Section
            Route::get('/Engagement_Type_Section/{section}', 'getEngagementTypeSection');
            Route::post('/Engagement_Type_Section/{section}', 'updateEngagementTypeSection');

            // Engagement Work Section
            Route::get('/Engagement_Work_Section/{section}', 'getEngagementWorkSection');
            Route::post('/Engagement_Work_Section/{section}', 'updateEngagementWorkSection');

            // Expertise Areas Section
            Route::get('/Expertise_Areas_Section/{section}', 'getExpertiseAreasSection');
            Route::post('/Expertise_Areas_Section/{section}', 'updateExpertiseAreasSection');

            // Process Section
            Route::get('/Process_Section/{section}', 'getProcessSection');
            Route::post('/Process_Section/{section}', 'updateProcessSection');


            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Advisory Page
        Route::prefix('/advisory-page')->controller(AdvisoryCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Engagement Type Section
            Route::get('/Needs_Section/{section}', 'getNeedsSection');
            Route::post('/Needs_Section/{section}', 'updateNeedsSection');

            // Engagement Work Section
            Route::get('/Engagement_Work_Section/{section}', 'getEngagementWorkSection');
            Route::post('/Engagement_Work_Section/{section}', 'updateEngagementWorkSection');

            // Expertise Areas Section
            Route::get('/Expertise_Areas_Section/{section}', 'getExpertiseAreasSection');
            Route::post('/Expertise_Areas_Section/{section}', 'updateExpertiseAreasSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });
    });

    Route::prefix('/our-capabilities-page')->controller(OurCapabilitiesCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        Route::get('/inner-pages', 'getInnerPagesList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Capabilities Section
        Route::get('/Capabilities_Section/{section}', 'getCapabilitiesSection');
        Route::post('/Capabilities_Section/{section}', 'updateCapabilitiesSection');

        // Cards Section
        Route::get('/Cards_Section/{section}', 'getCardsSection');
        Route::post('/Cards_Section/{section}', 'updateCardsSection');

        // Work Togather Section
        Route::get('/Work_Togather_Section/{section}', 'getWorkTogatherSection');
        Route::post('/Work_Togather_Section/{section}', 'updateWorkTogatherSection');

        // Delivery Modules Section
        Route::get('/Delivery_Modules_Section/{section}', 'getDeliveryModulesSection');
        Route::post('/Delivery_Modules_Section/{section}', 'updateDeliveryModulesSection');

        // Expertise Section
        Route::get('/Expertise_Section/{section}', 'getExpertiseSection');
        Route::post('/Expertise_Section/{section}', 'updateExpertiseSection');

        // Clearity Section
        Route::get('/Clearity_Section/{section}', 'getClaritySection');
        Route::post('/Clearity_Section/{section}', 'updateClaritySection');

        // Inner Pages

        // Transformation Page

        Route::prefix('/transformation-page')->controller(TransformationCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Transformation Fails Section
            Route::get('/Transformations_Fails_Section/{section}', 'getTransformationFailsSection');
            Route::post('/Transformations_Fails_Section/{section}', 'updateTransformationFailsSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Focus Areas Section
            Route::get('/Focus_Areas_Section/{section}', 'getFocusAreaSection');
            Route::post('/Focus_Areas_Section/{section}', 'updateFocusAreaSection');

            // Approach Areas Section
            Route::get('/Approach_Section/{section}', 'getApproachSection');
            Route::post('/Approach_Section/{section}', 'updateApproachSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Artificial Intelligence Page

        Route::prefix('/artificial-intelligence-page')->controller(ArtificialIntelligenceCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Transformation Fails Section
            Route::get('/Projects_Fails_Section/{section}', 'getProjectsFailsSection');
            Route::post('/Projects_Fails_Section/{section}', 'updateProjectsFailsSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Applications Section
            Route::get('/Applications_Section/{section}', 'getApplicationsSection');
            Route::post('/Applications_Section/{section}', 'updateApplicationsSection');

            // Implementation Section
            Route::get('/Implementation_Section/{section}', 'getImplementationSection');
            Route::post('/Implementation_Section/{section}', 'updateImplementationSection');

            // Technology Stack Section
            Route::get('/Technology_Stack_Section/{section}', 'getTechnologyStackSection');
            Route::post('/Technology_Stack_Section/{section}', 'updateTechnologyStackSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Security Page

        Route::prefix('/security-page')->controller(SecurityCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // We Do Fails Section
            Route::get('/We_Do_Section/{section}', 'getWeDoSection');
            Route::post('/We_Do_Section/{section}', 'updateWeDoSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Security Matter Section
            Route::get('/Security_Matters_Section/{section}', 'getSecurityMattersSection');
            Route::post('/Security_Matters_Section/{section}', 'updateSecurityMattersSection');

            // Security Process Section
            Route::get('/Security_Process_Section/{section}', 'getSecurityProcessSection');
            Route::post('/Security_Process_Section/{section}', 'updateSecurityProcessSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Technology Stack Section
            Route::get('/Expertise_Section/{section}', 'getExpertiseSection');
            Route::post('/Expertise_Section/{section}', 'updateExpertiseSection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Infrastructure Page

        Route::prefix('/infrastructure-page')->controller(InfrastructureCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Infrastructure Matters Section
            Route::get('/Infrastructure_Matters_Section/{section}', 'getInfrastructureMattersSection');
            Route::post('/Infrastructure_Matters_Section/{section}', 'updateInfrastructureMattersSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Components Section
            Route::get('/Components_Section/{section}', 'getComponentsSection');
            Route::post('/Components_Section/{section}', 'updateComponentsSection');

            // Reliability Section
            Route::get('/Reliability_Section/{section}', 'getReliabilitySection');
            Route::post('/Reliability_Section/{section}', 'updateReliabilitySection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Enterprise-Applications Page

        Route::prefix('/enterprise-applications-page')->controller(EnterpriseApplicationsCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Approach Section
            Route::get('/Approach_Section/{section}', 'getApproachSection');
            Route::post('/Approach_Section/{section}', 'updateApproachSection');

            // We Build Section
            Route::get('/We_Build_Section/{section}', 'getWeBuildSection');
            Route::post('/We_Build_Section/{section}', 'updateWeBuildSection');

            // Technologies We Use Section
            Route::get('/Technologies_We_Use_Section/{section}', 'getTechnologiesWeUseSection');
            Route::post('/Technologies_We_Use_Section/{section}', 'updateTechnologiesWeUseSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Applications Page

        Route::prefix('/applications-page')->controller(ApplicationsCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Approach Section
            Route::get('/Approach_Section/{section}', 'getApproachSection');
            Route::post('/Approach_Section/{section}', 'updateApproachSection');

            // We Build Section
            Route::get('/We_Build_Section/{section}', 'getWeBuildSection');
            Route::post('/We_Build_Section/{section}', 'updateWeBuildSection');

            // Technologies We Use Section
            Route::get('/Technologies_We_Use_Section/{section}', 'getTechnologiesWeUseSection');
            Route::post('/Technologies_We_Use_Section/{section}', 'updateTechnologiesWeUseSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Data-Engineering Page

        Route::prefix('/data-engineering-page')->controller(DataEngineeringCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Data Engineering Matters Section
            Route::get('/Data_Engineering_Matters_Section/{section}', 'getDataEngineeringMattersSection');
            Route::post('/Data_Engineering_Matters_Section/{section}', 'updateDataEngineeringMattersSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Components Section
            Route::get('/Components_Section/{section}', 'getComponentsSection');
            Route::post('/Components_Section/{section}', 'updateComponentsSection');

            // Technologies We Use Section
            Route::get('/Technologies_We_Use_Section/{section}', 'getTechnologiesWeUseSection');
            Route::post('/Technologies_We_Use_Section/{section}', 'updateTechnologiesWeUseSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });

        // Cloud Page

        Route::prefix('/cloud-page')->controller(CloudCmsController::class)->group(function () {
            Route::get('/main-list', 'getMainSectionsList');

            // Banner Section
            Route::get('/Banner_Section/{section}', 'getBannerSection');
            Route::post('/Banner_Section/{section}', 'updateBannerSection');

            // Priority Section
            Route::get('/Priority_Section/{section}', 'getPrioritySection');
            Route::post('/Priority_Section/{section}', 'updatePrioritySection');

            // Matter Section
            Route::get('/Matter_Section/{section}', 'getMatterSection');
            Route::post('/Matter_Section/{section}', 'updateMatterSection');

            // Migration_Fails_Section
            Route::get('/Migration_Fails_Section/{section}', 'getMigrationFailsSection');
            Route::post('/Migration_Fails_Section/{section}', 'updateMigrationFailsSection');

            // Services Section
            Route::get('/Services_Section/{section}', 'getServicesSection');
            Route::post('/Services_Section/{section}', 'updateServicesSection');

            // Work_With Section
            Route::get('/Work_With_Section/{section}', 'getWorkWithSection');
            Route::post('/Work_With_Section/{section}', 'updateWorkWithSection');

            // Optimization Section
            Route::get('/Optimization_Section/{section}', 'getOptimizationSection');
            Route::post('/Optimization_Section/{section}', 'updateOptimizationSection');

            // Security Compliance Section
            Route::get('/Security_Compliance_Section/{section}', 'getSecurityComplianceSection');
            Route::post('/Security_Compliance_Section/{section}', 'updateSecurityComplianceSection');

            // Cased Study Section
            Route::get('/Case_Study_Section/{section}', 'getCaseStudySection');
            Route::post('/Case_Study_Section/{section}', 'updateCaseStudySection');

            // Clearity Section
            Route::get('/Clearity_Section/{section}', 'getClaritySection');
            Route::post('/Clearity_Section/{section}', 'updateClaritySection');
        });
    });

    // Solo Sections
    Route::prefix('/solo')->controller(SoloSectionsCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');
        // Testimonials Section
        Route::get('/Testimonials_Section/{section}', 'getTestimonialsSection');
        Route::post('/Testimonials_Section/{section}', 'updateTestimonialsSection');

        // Newsletter Section
        Route::get('/Newsletter_Section/{section}', 'getNewslettersSection');
        Route::post('/Newsletter_Section/{section}', 'updateNewslettersSection');

        // Marque TagLine Section
        Route::get('/Marque_Tagline_Section/{section}', 'getMarqueTagLineSection');
        Route::post('/Marque_Tagline_Section/{section}', 'updateMarqueTagLineSection');

        // Social Links Section
        Route::get('/Social_Links_Section/{section}', 'getSocialLinksSection');
        Route::post('/Social_Links_Section/{section}', 'updateSocialLinksSection');
    });

    // About Us Page
    Route::prefix('/about-us-page')->controller(AboutUsPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Content Section
        Route::get('/Content_Section/{section}', 'getContentSection');
        Route::post('/Content_Section/{section}', 'updateContentSection');

        // Capabilities Section
        Route::get('/Capabilities_Section/{section}', 'getCapabilitiesSection');
        Route::post('/Capabilities_Section/{section}', 'updateCapabilitiesSection');

        // Business Section
        Route::get('/Business_Section/{section}', 'getBusinessSection');
        Route::post('/Business_Section/{section}', 'updateBusinessSection');

        // Why Choose Us Section
        Route::get('/Why_Choose_Us_Section/{section}', 'getWhyChooseUsSection');
        Route::post('/Why_Choose_Us_Section/{section}', 'updateWhyChooseUsSection');

        // Available Section
        Route::get('/Available_Section/{section}', 'getAvailableSection');
        Route::post('/Available_Section/{section}', 'updateAvailableSection');

        // Advisory Section
        Route::get('/Advisory_Section/{section}', 'getAdvisorySection');
        Route::post('/Advisory_Section/{section}', 'updateAdvisorySection');
    });

    // Contact Us Page
    Route::prefix('/contact-us-page')->controller(ContactUsPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Tagline Section
        Route::get('/Tagline_Section/{section}', 'getTaglineSection');
        Route::post('/Tagline_Section/{section}', 'updateTaglineSection');

        // Talk To Us Section
        Route::get('/Talk_To_Us_Section/{section}', 'getTalkToUsSection');
        Route::post('/Talk_To_Us_Section/{section}', 'updateTalkToUsSection');

        // Contact Us Section
        Route::get('/Contact_Us_Section/{section}', 'getContactUsSection');
        Route::post('/Contact_Us_Section/{section}', 'updateContactUsSection');

        // Client Section
        Route::get('/Client_Section/{section}', 'getClientSection');
        Route::post('/Client_Section/{section}', 'updateClientSection');

        // What Happens Next Section
        Route::get('/What_Happens_Next_Section/{section}', 'getWhatHappensNextSection');
        Route::post('/What_Happens_Next_Section/{section}', 'updateWhatHappensNextSection');

        // Let Talk Section
        Route::get('/Let_Talk_Section/{section}', 'getLetTalkSection');
        Route::post('/Let_Talk_Section/{section}', 'updateLetTalkSection');

        // Links Section
        Route::get('/Links_Section/{section}', 'getLinksSection');
        Route::post('/Links_Section/{section}', 'updateLinksSection');

        // FAQ Section
        Route::get('/FAQ_Section/{section}', 'getFAQSection');
        Route::post('/FAQ_Section/{section}', 'updateFAQSection');
    });

    // Privacy Policy Page
    Route::prefix('/privacy-policy-page')->controller(PrivacyPolicyPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Content Section
        Route::get('/Content_Section/{section}', 'getContentSection');
        Route::post('/Content_Section/{section}', 'updateContentSection');

        // Contact Section
        Route::get('/Contact_Section/{section}', 'getContactSection');
        Route::post('/Contact_Section/{section}', 'updateContactSection');
    });

    // Terms & Condition Page
    Route::prefix('/terms-condition-page')->controller(TermsConditionPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Content Section
        Route::get('/Content_Section/{section}', 'getContentSection');
        Route::post('/Content_Section/{section}', 'updateContentSection');

        // Contact Section
        Route::get('/Contact_Section/{section}', 'getContactSection');
        Route::post('/Contact_Section/{section}', 'updateContactSection');
    });

    // Blogs Page
    Route::prefix('/blogs-page')->controller(BlogsPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // CRUD
        Route::get('/', 'index');
        Route::get('/show/{blog}', 'show');
        Route::post('/create', 'store');
        Route::post('/update/{blog}', 'update');
    });

    // FAQ Page
    Route::prefix('/faq-page')->controller(FAQPageCmsController::class)->group(function () {
        Route::get('/main-list', 'getMainSectionsList');

        // Banner Section
        Route::get('/Banner_Section/{section}', 'getBannerSection');
        Route::post('/Banner_Section/{section}', 'updateBannerSection');

        // Content Section
        Route::get('/Content_Section/{section}', 'getContentSection');
        Route::post('/Content_Section/{section}', 'updateContentSection');

        // Clarity Section
        Route::get('/Clarity_Section/{section}', 'getClaritySection');
        Route::post('/Clarity_Section/{section}', 'updateClaritySection');

        // Questionary Section
        Route::get('/Questionary_Section/{section}', 'getQuestionarySection');
        Route::post('/Questionary_Section/{section}', 'storeQuestionarySection');
        Route::post('/Questionary_Section/update/{cms}', 'updateQuestionarySection');

    });

    // Footer
    Route::prefix('/footer')->controller(FooterCmsSectionController::class)->group(function () {
        // Footer Section List
        Route::get('/main_list', 'getFooterSectionsList');

        // Footer Section
        Route::get('/Footer_Section/{section}', 'getFooterSection');
        Route::post('/Footer_Section/{section}', 'updateFooterSection');

        // Footer Section
        Route::get('/Footer_Navigation/{section}', 'getFooterNavigationSectionList');
        Route::get('/Footer_Navigation/navigation/{navigation}', 'getFooterNavigation');
        Route::post('/Footer_Navigation/update-navigation/{navigation}', 'updateFooterNavigation');
    });
});
