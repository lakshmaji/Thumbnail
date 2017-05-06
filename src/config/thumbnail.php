<?php

/*
|--------------------------------------------------------------------------
| File which returns array of constants containing the thumbnail 
| integration configurations. 
|--------------------------------------------------------------------------
|
*/

return array(

    /*
    |--------------------------------------------------------------------------
    | FFMPEG BINARIES CONFIGURATIONS
    |--------------------------------------------------------------------------
    |
    | If you want to give binary paths explicitly, you can configure the FFMPEG 
    | binary paths set to the below 'env' varibales.
    |
    | NOTE: FFMpeg will autodetect ffmpeg and ffprobe binaries.
    |
    */

    'binaries' => [
        'enabled' => env('FFMPEG_BINARIES', false),
        'path'    => [
            'ffmpeg'  => env('FFMPEG_PATH', '/opt/local/ffmpeg/bin/ffmpeg'),
            'ffprobe' => env('FFPROBE_PATH', '/opt/local/ffmpeg/bin/ffprobe'),
            'timeout' => env('FFMPEG_TIMEOUT', 3600), // The timeout for the underlying process
            'threads' => env('FFMPEG_THREADS', 12), // The number of threads that FFMpeg should use
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail image dimensions
    |--------------------------------------------------------------------------
    |
    | Specify the dimensions for thumbnail image
    |
    */

    'dimensions' => [
        'width'  => env('THUMBNAIL_IMAGE_WIDTH', 320),
        'height' => env('THUMBNAIL_IMAGE_HEIGHT', 240),
    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail watermark alpha
    |--------------------------------------------------------------------------
    |
    | Specify the secret THUMBNAIL_X
    |
    */

    'watermark' => [
        'image' => [
            'enabled' => env('WATERMARK_IMAGE', false),
            'path'    => env('WATERMARK_PATH', 'http://voluntarydba.com/pics/YouTube%20Play%20Button%20Overlay.png'),
        ],
        'video' => [
            'enabled' => env('WATERMARK_VIDEO', false),
            'path'    => env('WATERMARK_PATH', ''),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Thumbnail some x
    |--------------------------------------------------------------------------
    |
    | Specify the secret THUMBNAIL_X
    |
    */

    'THUMBNAIL_X' => '<YOUR_THUMBNAIL_X>',

);

// php artisan vendor:publish

// end of file thumbnail.php