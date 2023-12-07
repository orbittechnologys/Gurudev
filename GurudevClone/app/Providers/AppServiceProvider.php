<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Announcement;
use App\Models\ModuleDetail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        error_reporting(0);
        $this->app['request']->server->set('HTTP','on');
        view()->composer('*', function ($view) {
            //  dd(Admin::getAdmin('is_super'));
            if (Auth::guard('admin')->check()) {
                if (!Admin::getAdmin('is_super')) {

                    $callback = function ($defaultSubModule) {

                        $defaultSubModule->where(['is_default' => 1])
                            ->orWhereHas('userRoleDetail')
                            ->orderBy('position', 'ASC');

                        $defaultSubModule->whereHas('userRoleDetail', function ($userRoleDetail) {
                            $userRoleDetail->join('user_roles', function ($join) {
                                $join->on('user_role_details.user_role_id', '=', 'user_roles.id');

                                $join->where(function ($q) {
                                    $q->where('action_add', '1')
                                        ->orWhere('action_edit', '1')
                                        ->orWhere('action_delete', '1');
                                });

                                $join->where('staff_id',  Auth::guard('admin')->user()->id);
                            });
                        });
                    };
                    $userRoleMainMenu = ModuleDetail::where(function ($query) use ($callback) {
                        $query->where(['status' => 'Active']);
                        $query->whereHas('subModule', $callback);
                        /*  $query->orWhereHas('userRole',$userRoleCallBack);*/
                    })
                        ->with(['subModule' => $callback])
                        ->orderBy('position', 'ASC')
                        ->get()->toArray();
                } else if (Admin::getAdmin('is_super')) {
                    $userRoleMainMenu = ModuleDetail::where(function ($query) {
                        $query->where(['status' => 'Active']);
                        $query->whereHas('subModule');
                    })->with(['subModule' => function ($submodule) {
                        $submodule->orderBy('position', 'ASC');
                    }])
                        ->orderBy('position', 'ASC')
                        ->get()->toArray();
                }
                View::share('userRoleMainMenu', $userRoleMainMenu);
                Paginator::useBootstrap();
            } else if (Auth::check()) {
                $Announcement=Cache::rememberForever('Announcement', function()
                {  $news=Announcement::orderBy('id', 'DESC')->take(6)->get();
                  return $news;
                });
                View::share('notifications', $Announcement);
                View::share('colors', ['danger', 'info', 'success', 'warning', 'primary', 'danger', 'info']);
                Paginator::useBootstrap();
            }
        });
    }
}
