<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\SettingModel;
use App\Modules\Api\Models\ChatThreadModel;
use Validator;
use App\Modules\Api\Models\PageModel;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //force ssl
        if (!\App::environment('local')) {
            \URL::forceSchema('https');
            \DB::connection()->disableQueryLog();
        }

        Validator::extend('phone', 'App\Http\Controllers\CustomValidator@validatePhone');
        Validator::extend('hashmatch', 'App\Http\Controllers\CustomValidator@validateOldPassword');
        Validator::extend('country', 'App\Http\Controllers\CustomValidator@validateCountry');

        view()->composer('frontend', function ($view) {
          //publish categories to whole frontend
          $view->with('categories', \App\Modules\Api\Models\CategoryModel::archives());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
        $this->app->singleton('settings', function ($app) {
            return SettingModel::first();
        });
        //return user timezone here
        $this->app->singleton('userSettings', function ($app) {
            $userData = AppSession::getLoginData();
            if ($userData) {
                //TODO get user settings
                $user = UserModel::select('usersettings')->where('id', $userData->id)->first();

                if ($user && AppHelper::is_serialized($user->usersettings)) {
                    return unserialize($user->usersettings);
                }
                return null;
            }
            return null;
        });
        //count dating online
        $this->app->singleton('online', function ($app) {
            $dating = ChatThreadModel::join('users as u', 'u.id', '=', 'chatthreads.ownerId')
                    ->where('chatthreads.isStreaming', 1)
                    ->where('chatthreads.type', ChatThreadModel::TYPE_GROUP)
                    ->where('u.role', UserModel::ROLE_MODEL)
                    ->count();
            return (object) ['dating' => $dating];
        });

        $this->app->singleton('pages', function($app) {
            return PageModel::select('title', 'alias')
                            ->where('status', '=', PageModel::STATUS_ACTIVE)
                            ->orderBy('sort')
                            ->get();
        });
    }

}
