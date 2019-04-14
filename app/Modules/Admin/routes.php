<?php

Route::group(array('module' => 'Admin', 'namespace' => 'App\Modules\Admin\Controllers'), function() {

//  Route::resource('admin', 'AdminController');

  Route::get('admin', 'AdminController@index');
  Route::get('admin/login', 'AuthController@login');
  Route::post('admin/login', 'AuthController@loginProcess');
  Route::get('admin/forgot-password', 'AuthController@forgotPassword');
  Route::post('admin/forgot-password', 'AuthController@processForgotPassword');
  
  Route::get('admin/logout', 'AuthController@Logout');
  Route::get('document/{id}', 'DocumentController@readFile');
  Route::group(array('middleware' => 'AdminCheckLogin', 'prefix' => 'admin'), function() {

    Route::get('dashboard', 'AdminController@dashboard');

    Route::get('manager/members', 'UserController@getMemberUsers');
    Route::get('manager/members/transactions', 'PaymentController@getMemberTransactions');
    Route::get('manager/performers', 'UserController@getModelUsers');
    Route::get('manager/performers-pending', 'UserController@getModelPending');
    Route::get('manager/performers/online', 'UserController@getModelOnline');
    Route::get('manager/performers/approve/{id}', 'UserController@approveModel');
    Route::get('manager/performers/online/watching/{threadId}', 'UserController@getWatching');
    Route::get('manager/performerstudios', 'UserController@getStudioUsers');
    Route::get('manager/performerstudios-pending', 'UserController@getStudioPending');    
    Route::get('manager/performercategories', 'CategoryController@getPerformerCategories');
    //Member
    Route::get('manager/member/add', 'UserController@addMember');
    Route::get('manager/member-profile/{id}', 'UserController@getMemberProfile');
    Route::post('manager/member-profile/{id}', 'UserController@updateMemberProcess');
    Route::post('manager/member/add', 'UserController@addMemberProcess');
    Route::get('manager/user/disable/{id}', 'UserController@destroy');
    //Model
    Route::get('manager/model/add', 'UserController@addModel');
    Route::get('manager/model-profile/{id}', 'UserController@getModelProfile');
    Route::post('manager/model-profile/{id}', 'UserController@updateModelProcess');
    Route::post('manager/model/add', 'UserController@addModelProcess');

    Route::get('manager/video-gallery/{id}', 'GalleryController@getVideoGallery');
    Route::get('manager/image-gallery/{id}', 'GalleryController@getImageGallery');
    Route::get('manager/video-gallery/edit/{id}', 'GalleryController@getEditVideoGallery');
    Route::get('manager/media/video-gallery/{modelId}/upload-video', 'MediaController@uploadVideo');
    Route::get('manager/media/video-gallery/{modelId}/edit-video/{id}', 'MediaController@editVideo');
    Route::get('manager/media/video-gallery/{id}', 'GalleryController@getListVideos');
    Route::get('manager/media/video-gallery/{modelId}/upload/{galleryId}', 'MediaController@uploadNewVideo');
    Route::get('manager/media/edit-video/{galleryId}', 'MediaController@editVideoInfo');


    Route::get('manager/media/image-gallery/{id}', 'GalleryController@getListImages');
    Route::get('manager/image-gallery/edit/{id}', 'GalleryController@getEditImageGallery');
    //Gallery
    Route::get('manager/media/add-video-gallery/{id}', 'GalleryController@addVideoGallery');
    Route::get('manager/media/add-image-gallery/{id}', 'GalleryController@addImageGallery');
    Route::get('manager/media/add-image/{modelId}', 'GalleryController@addImage');
    Route::get('manager/media/edit-image/{modelId}/{galleryId}', 'GalleryController@editImage');
    //Studio
    Route::get('manager/studio/add', 'UserController@addStudio');
    Route::get('manager/studio-profile/{id}', 'UserController@getStudioProfile');
    Route::post('manager/studio-profile/{id}', 'UserController@updateStudioProcess');
    Route::post('manager/studio/add', 'UserController@addStudioProcess');

    //Commission
    Route::get('manager/commission', 'CommissionController@index');
    Route::get('manager/commission/model', 'CommissionController@getModels');
    Route::get('manager/commission/studio', 'CommissionController@getStudios');
    Route::get('manager/commission/detail/{id}', 'CommissionController@getDetail');
    Route::get('manager/commission/edit/{id}', 'CommissionController@getEdit');
    Route::post('manager/commission/edit/{id}', 'CommissionController@updateCommission');

    //Payment management
    Route::get('manager/paymentsystems', 'PaymentController@getSettings');
    Route::post('manager/paymentsystems', 'PaymentController@postSettings');
    Route::get('manager/paymentpackages', 'PaymentController@getPackages');
    Route::get('manager/paymentpackage/add', 'PaymentController@addPackage');
    Route::post('manager/paymentpackage/add', 'PaymentController@postPackage');
    Route::get('manager/paymentpackage/edit/{id}', 'PaymentController@editPackage');
    Route::post('manager/paymentpackage/update/{id}', 'PaymentController@updatePackage');
    Route::get('manager/paymentpackage/delete/{id}', 'PaymentController@deletePackage');

    //Payment detail
    Route::get('manager/payments/videos', 'PaymentController@getPaymentVideos');
    Route::get('manager/payments/galleries', 'PaymentController@getPaymentGalleries');
    Route::get('manager/payments/others', 'PaymentController@getPaymentOthers');
    Route::get('manager/payments/products', 'PaymentController@getPaymentProducts');
    Route::get('manager/payments/products/{id}', 'PaymentController@getPaymentProductsDetail');
    Route::get('manager/payments/products/{id}/refund', 'PaymentController@refundPaymentProduct');
    Route::post('manager/payments/{type}', 'PaymentController@processPaymentAction');
    Route::get('manager/payments/delete/{id}', 'PaymentController@deletePayment');
    
    //Reject Transaction
    Route::get('manager/transaction/reject/{id}', 'PaymentController@rejectTransaction');
    Route::get('manager/transaction/approve/{id}', 'PaymentController@approveTransaction');

//export to excel
    Route::get('manager/payments/export/{type}', 'PaymentController@exportExcel');

    Route::get('manager/payments/reject/{id}', 'PaymentController@rejectPayment');
    Route::get('manager/payments/approve/{id}', 'PaymentController@approvePayment');

    //Setting
    Route::get('dashboard/settings', 'AdminController@getSettings');
    Route::post('dashboard/settings', 'AdminController@updateSettings');
    //SEO
    Route::get('dashboard/settings/seo', 'AdminController@getSeoSettings');
    Route::post('dashboard/settings/seo', 'AdminController@updateSeoSettings');
    //Profile
    Route::get('manager/profile', 'UserController@getMyProfile');
    Route::post('manager/profile', 'UserController@updateMyProfile');
   
    //document
    Route::get('document/{id}', 'DocumentController@readFile');
    
    //Content manager
    Route::get('pages', 'ContentController@getPages');
    Route::get('page/new', 'ContentController@create');
    Route::post('page/newPage', 'ContentController@postPage');
    Route::get('page/edit/{id}', 'ContentController@getEditPage');
    Route::put('page/edit/{id}', 'ContentController@putEditPage');
    Route::get('page/delete/{id}', 'ContentController@deletePage');
    
     //account status
    Route::get('manager/profile/disable/{id}', 'UserController@disableAccount');
    Route::get('manager/profile/delete/{id}', 'UserController@deleteAccount');
    Route::get('manager/profile/approve/{id}', 'UserController@approveAccount');
    Route::get('manager/profile/suspend/{id}', 'UserController@suspendAccount');
    Route::get('manager/profile/identification/{id}', 'DocumentController@getDetail');
    Route::get('manager/model/chat/{id}', 'ChatMessageController@getMessages');
    Route::get('manager/message/delete/{id}', 'ChatMessageController@destroy');

     //request payout
    Route::get('requestpayout/performers/listing', 'RequestPayoutController@listing');
    Route::get('requestpayout/studios/listing', 'RequestPayoutController@listingStudio');
    Route::get('requestpayout/{id}', 'RequestPayoutController@view');
    Route::get('requestpayout/{id}/delete', 'RequestPayoutController@delete');

    Route::get('stats/performer', 'StatsController@getModelStats');
    Route::get('stats/reset-earning/{userId}', 'StatsController@resetEarning');
    Route::get('stats/studio', 'StatsController@getStudioStats');  
    Route::get('stats/studio-model/{studioId}', 'StatsController@getStudioModels');
  });
});
