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
use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate;



/**
 * Thumbnail - A Thumbnail package for Thumbnail Images 
 *
 * @author     lakshmaji 
 * @package    Thumbnail
 * @version    1.0.0
 * @since      Class available since Release 1.0.0
 */
class Thumbnail
{

    /**
     * Create Thumbnail Image
     *
     * Create a new image from video source based on the specified parameters. 
     * This method will allows video to convert to image.
     *
     *  
     * @access public
     * @since  Method available since Release 1.0.0
     * @param  video_path      Video resource source path 
     * @param  storage_path    Image resource destination path
     * @param  thumbnail_name  Image name for output
     * @param  height          
     * @param  width
     *
     * @author lakshmajim 
     * @return boolean 
     */
    public function getThumbnail($video_path,$storage_path,$thumnail_name,$height=320,$width=240)
    {
        try
        {
            $ffmpeg = FFMpeg::create();
            $video  = $ffmpeg->open($video_path);
            $video
                ->filters()
                ->resize(new Coordinate\Dimension($height, $width)) 
                ->synchronize();//320, 240
            $video
                ->frame(Coordinate\TimeCode::fromSeconds(10))
                ->save($storage_path.'/'.$thumnail_name);

            if($video)
            {
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
            echo "Got Cookie";
        }
    }

    //-------------------------------------------------------------------------

}
// //end of Thumbnail class
// // end of file Thumbnail.php