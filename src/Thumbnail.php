<?php

/*
|--------------------------------------------------------------------------
| Thumbnail class for implementing video thumbnail features with laravel 
|--------------------------------------------------------------------------
|
*/

namespace Lakshmaji\Thumbnail;

use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate;
use App\Http\Requests;
use FFMpeg\Format\Video;
use Illuminate\Http\Request;


/**
 * Thumbnail - A Thumbnail package for Thumbnail Images 
 *
 * @author     lakshmaji 
 * @package    Thumbnail
 * @version    1.4.4
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
     * @param  video_path      Video resource source path 
     * @param  storage_path    Image resource destination path
     * @param  thumbnail_name  Image name for output
     * @param  tts             Time to take screenshot          [optional]
     * @return boolean 
     *
     * @since   Method available since Release 1.0.0
     * @version 1.4.4
     * @author  lakshmajim 
     */
    public function getThumbnail($video_path,$storage_path,$thumnail_name,$tts=10)
    {

        try {
            if(config('thumbnail.binaries.enabled')) {
                $ffmpeg = FFMpeg::create(
                    array(
                        'ffmpeg.binaries'  => config('thumbnail.binaries.path.ffmpeg'),
                        'ffprobe.binaries' => config('thumbnail.binaries.path.ffprobe'),
                        'timeout'          => config('thumbnail.binaries.path.timeout'),
                        'ffmpeg.threads'   => config('thumbnail.binaries.path.threads'),
                    )
                );
            } 
            else {
                $ffmpeg   = FFMpeg::create();   
            }
            
            $video        = $ffmpeg->open($video_path);
            $result_image = $storage_path.'/'.$thumnail_name;

            $video
                ->filters()
                ->resize(new Coordinate\Dimension(config('thumbnail.dimensions.height'), config('thumbnail.dimensions.width'))) 
                ->synchronize();//320, 240
            $video
                ->frame(Coordinate\TimeCode::fromSeconds($tts))
                ->save($result_image);

            if($video) {
                if(config('thumbnail.watermark.image.enabled')) {
                    $src       = imagecreatefrompng(config('thumbnail.watermark.image.path'));
                    $got_image = imagecreatefromjpeg($result_image);
            
                    // Get dimensions of image screen shot
                    $width     = imagesx($got_image);
                    $height    = imagesy($got_image);

                    // final output image dimensions
                    $newwidth  = config('thumbnail.dimensions.width');   
                    $newheight = config('thumbnail.dimensions.height');

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
            else {
                return false;
            }
        } catch(Exception $thumbnailException) {
            // error processing request
            throw new Exception($thumbnailException->getMessage());            
        }
    }

    //-------------------------------------------------------------------------


    /**
     * Clips the given video
     *
     * Create a new clipped video of type WebM
     * from the given video
     * 
     * 
     * @access public
     * @param  src        Video resource source path 
     * @param  dest       Video resource destination path
     * @param  from       Clipping start time
     * @param  to         Clipping end time
     * @return boolean 
     *
     * @since   Method available since Release 1.4.4
     * @version 1.4.4
     * @author  lakshmajim 
     */
    public function clipWebM($src, $dest, $from, $to)
    {
        $ffmpeg = FFMpeg::create();
        $video  = $ffmpeg->open($src);

        if($from >= $to) 
            throw new Exception("The start clipping time must be less than end clipping time");
            
        $video
            ->filters()
            ->clip(Coordinate\TimeCode::fromSeconds($from), Coordinate\TimeCode::fromSeconds($to));

        $video
            ->save(new Video\WebM(), $dest);

        if($video) return true;
        else return false;
    }

    //-------------------------------------------------------------------------


    /**
     * Insert watermark on the given video
     *
     * 
     * 
     * @access public
     * @param  src        Video resource source path 
     * @param  dest       Video resource destination path
     * @return boolean 
     *
     * @since   Method available since Release 1.4.4
     * @version 1.4.4
     * @author  lakshmajim 
     */
    public function watermarkVideo($src, $dest)
    {
        $ffmpeg = FFMpeg::create();
        $video  = $ffmpeg->open($src);

        if(!config('thumbnail.watermark.video.enabled')) 
            throw new Exception("Configure watermark path in env file");
            
        // $video->filters()->resize($dimension, $mode, $useStandards);
        $video
            ->filters()
            ->watermark(config('thumbnail.watermark.video.path'), array(
                'position' => 'relative',
                'bottom' => 50,
                'right' => 50,
            ));


        $video
            ->save(new Video\WebM(), $dest);        

        if($video) return true;
        else return false;
    }

    //-------------------------------------------------------------------------
}
// //end of Thumbnail class
// // end of file Thumbnail.php
