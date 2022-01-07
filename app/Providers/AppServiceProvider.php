<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use App\Category;
use DB;

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
        //أضفت هالسطر لأنه كان عم يطلع لي خطأ عند عمل migrate
        // لأنه نسخة الـ mysql عندي قديمة وما قدرت هلق اعملها تحديث مشان حجمها
        // وما ننس نضيف السطر فوق
        // use Illuminate\Support\Facades\Schema;
        Schema::defaultStringLength(191);

        
        //-----------------------------
        // تايع composer
        // بيسمحلنا نبعت view 
        // معين لكل view
        // ونحنا هون بدنا نبعت التصنيفات لكل الصفحات مشان نحطها بالـ 
        // dropdown
        // وبدنا ياها تظهر بالـ navigation
        View::composer('*', function($view)
        {
            $view->with('dropCategories', DB::table('categories')->orderBy('name')->get());
        });
    }
}
