@extends('frontend')
@section('title','Model Video')
@section('content')
<div class="filter-bar">  <!-- FILTER BAR-->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="models_profiie_name">
                    <span>Helen Helen</span>PROFLE
                </div>
            </div>
            <div class=" col-sm-6">
                <div class="search">
                    <input placeholder="search comunity" type="text">
                </div>
            </div>
        </div>
    </div>
</div>    <!-- FILTER BAR END-->
<div class="content">
    <div class="prof_info_top"> <!-- top info block-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="prof_image">
                        <img src="http://placehold.it/800x600" alt=""/>
                        <div class="prof_type">Date profile</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5">
                    <div class="main_inf">
                        <div class="mod_name">Helen Helen</div>
                        <div class="mod_age"><span>Age:</span><span></span>22</div>
                        <div class="mod_loc"><span>Location:</span><span>Romania, Bucharest, Bucharest</span></div>
                        <div class="mod_for"><span>Model for:</span><span>about 1 year</span></div>
                        <div class="mod_last_online"><span>Last online:</span><span> about 1 year</span></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="btns_block">
                        <div class="online"><a href="" class="btn btn-dark btn-block disabled">Online chat <i class="fa fa-video-camera fa-2x"></i></a></div>
                        <div class="follow"><a href="" class="btn btn-dark btn-block">Follow</a></div>
                        <div class="like"><a href="" class="btn btn-dark btn-block">Like</a></div>
                        <div class="s_message"><a href="" class="btn btn-dark btn-block">Send message</a></div>
                        <div class="offline_tip"><a href="" class="btn btn-dark btn-block">Offline message<img src="images/heart-btn-icon.png" alt=""/></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- top info block-->
    <div class="prof_info_all"><!-- pot info block-->
        <div class="container sub_nav">
            <div class="row">
                <div class="col-xs-12">
                    <div class="collapse_cont">
                        <button type="button" class="btn btn-lg btn-rose btn-block">
                            <i class="fa fa-bars fa-lg"></i><span>Profile details</span>
                        </button>
                    </div>
                    <ul class="nav nav-justified collapsed">
                        <li><a href="">Profile</a></li>
                        <li><a href="">Wall</a></li>
                        <li><a href="">Full Bio</a></li>
                        <li><a href="">Videos</a></li>
                        <li class="active"><a href="">Pictures</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="profile_details container"> <!-- photo\video grid-->
        <div class="images_grid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <a href="#" class="thumbnail">
                        <img src="http://placehold.it/400x300" class="img-responsive">
                        <span class="sm_panel">
                            <span class="mod_name">Helen</span>
                            <span class="downloads">Downloads</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>     <!-- content end-->
@endsection