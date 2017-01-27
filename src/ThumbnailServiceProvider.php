<?php 

namespace Lakshmajim\Thumbnail;

use Illuminate\Support\ServiceProvider;


/**
 * The Thumbnail Controller
 *
 * Thumbnail - ServicePrivider to support integration with 
 * Laravel framework , which Define all methods associated
 * with a Thumbnail. Each and Every video has to be processed 
 * to produce thumbnail image
 *
 * @author     lakshmaji 
 * @package    Thumbnail
 * @version    1.4.0
 * @since      Class available since Release 1.0.0
 */
class ThumbnailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('thumbnail', function($app) {
            return new Thumbnail;
        });
    }
}
// end of ThumbnailServiceProvider class
// end of file ThumbnailServiceProvider 

