<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\CMS\AboutUsPageCmsController;
use App\Http\Controllers\Api\CMS\FooterCmsSectionController;
use App\Http\Controllers\Api\CMS\HeaderCmsController;
use App\Http\Controllers\Api\CMS\HomePageCmsController;
use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\NewsletterController;
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

Route::prefix('/newsletter')->controller(NewsletterController::class)->group(function () {
    Route::post('/store', 'store');
});
Route::prefix('/contact-us')->controller(ContactUsController::class)->group(function () {
    Route::post('/store', 'store');
});

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

        // Testimonials Section
        Route::get('/Testimonials_Section/{section}', 'getTestimonialsSection');
        Route::post('/Testimonials_Section/{section}', 'updateTestimonialsSection');

        // Newsletter Section
        Route::get('/Newsletter_Section/{section}', 'getNewslettersSection');
        Route::post('/Newsletter_Section/{section}', 'updateNewslettersSection');
    });
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
    });
});
