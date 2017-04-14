<?php

/*
|--------------------------------------------------------------------------
| Thumbnail class for implementing video thumbnail features with laravel 
|--------------------------------------------------------------------------
|
*/

namespace Lakshmajim\Thumbnail;

use Illuminate\Http\Request;
use App\Http\Requests;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate;


/**
 * Thumbnail - A Thumbnail package for Thumbnail Images 
 *
 * @author     lakshmaji <lakshmajee88@gmail.com>
 * @package    Thumbnail
 * @version    1.4.2
 * @since      Class available since Release 1.0.0
 */
class Thumbnail
{

    /**
     * Create Thumbnail Image
     *
     * Create a new image from video source based on the specified parameters. 
     * This method will allows video to convert to image.
     * This method will add watermark to image
     *
     *  
     * @access public
     * @since  Method available since Release 1.0.0
     * @param  video_path      Video resource source path 
     * @param  storage_path    Image resource destination path
     * @param  thumbnail_name  Image name for output
     * @param  height                                                  [optional]
     * @param  width                                                   [optional]
     * @param  tts             Time to take screenshot                 [optional]
     * @param  water_mark      Thmbnail paly button image              [optional]
     * @param  wm              if true the only it inserts play button [optional]
     * @author lakshmajim <lakshmajee88@gmail.com>
     * @return boolean 
     */
    public function getThumbnail($video_path,$storage_path,$thumnail_name,$height=320,$width=240,$tts=50,$water_mark='',$wm=false)
    {
        try
        {
            if(!empty(getenv('FFMPEG_PATH')))
            {
                $ffmpeg   = FFMpeg::create(
                    [
                        'ffmpeg.binaries'  => getenv('FFMPEG_PATH').'/ffmpeg',
                        'ffprobe.binaries' => getenv('FFMPEG_PATH').'/ffprobe',
                        'timeout'          => 3600, // The timeout for the underlying process
                        'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
                    ]
                );
            } 
            else {
                $ffmpeg   = FFMpeg::create();   
            }
            
            $video        = $ffmpeg->open($video_path);
            $result_image = $storage_path.'/'.$thumnail_name;

            $video
                ->filters()
                ->resize(new Coordinate\Dimension($height, $width)) 
                ->synchronize();//320, 240
            $video
                ->frame(Coordinate\TimeCode::fromSeconds($tts))
                ->save($result_image);

            if($video)
            {
                if($wm)
                {
                    $src       = imagecreatefrompng($water_mark);
                    $got_image = imagecreatefromjpeg($result_image);
            
                    // Get dimensions of image screen shot
                    $width     = imagesx($got_image);
                    $height    = imagesy($got_image);

                    // final output image dimensions
                    $newwidth  = env('THUMBNAIL_IMAGE_WIDTH');   
                    $newheight = env('THUMBNAIL_IMAGE_HEIGHT');

                    $tmp       = imagecreatetruecolor($newwidth,$newheight);

                    imagecopyresampled($tmp,$got_image,0,0,0,0,$newwidth,$newheight,$width,$height);

                    // Set the brush
                    imagesetbrush($tmp, $src);
                    // Draw a couple of brushes, each overlaying each
                    imageline($tmp, imagesx($tmp) / 2, imagesy($tmp) / 2, imagesx($tmp) / 2, imagesy($tmp) / 2, IMG_COLOR_BRUSHED);
                    imagejpeg($tmp,$result_image,100);
                }
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(Exception $thumbnailException)
        {
            // error processing request
            echo "Got Bad Cookie";
        }
    }

    //-------------------------------------------------------------------------


    /**
     * Clips the given video
     *
     * Create a new clipped video from the given video
     *
     *  
     * @access public
     * @since  Method available since Release 1.4.1
     * @param  src        Video resource source path 
     * @param  dest       Video resource destination path
     * @author lakshmajim <lakshmajee88@gmail.com>
     * @return boolean 
     */
    public function clip($src, $dest)
    {
        $ffmpeg = FFMpeg::create();
        $video  = $ffmpeg->open($src);

        $video
            ->filters()
            ->clip(Coordinate\TimeCode::fromSeconds(30), Coordinate\TimeCode::fromSeconds(15));

        $video
            ->save(new Format\Video\WebM(), $dest);
    }

    //-------------------------------------------------------------------------

}
// //end of Thumbnail class
// // end of file Thumbnail.php
