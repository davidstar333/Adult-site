<?php

Route::group(array('module' => 'Media', 'namespace' => 'App\Modules\Media\Controllers'), function() {


  Route::group(array('prefix' => 'media'), function() {

    
    
    Route::get('video/watch/{slug}', 'MediaController@getVideoDetail');
    Route::get('video/download/{id}', 'MediaController@downloadVideo');
    
    //Image
    Route::get('image-galleries', 'MediaController@getImageGalleries');
    Route::get('image-gallery/preview/{slug}', 'MediaController@getImageGallery');
    Route::get('image-gallery/download/{id}', 'MediaController@downloadImageGallery');
    //Buy gallery
    Route::get('image-gallery/{id}/buy', 'MediaController@buyImageGallery');
    //buy video

  });
  //Video
  Route::get('videos', 'MediaController@getVideos');
  Route::get('gallery/{slug}/videos', 'MediaController@getVideosByGallery');
  Route::get('video/{id}/buy', 'MediaController@buyVideo');
});
