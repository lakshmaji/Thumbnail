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
 * @version    1.1.0
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
     * @author lakshmajim 
     * @return boolean 
     */
    public function getThumbnail($video_path,$storage_path,$thumnail_name,$height=320,$width=240,$tts=50,$water_mark='',$wm=false)
    {
        try
        {
            $ffmpeg       = FFMpeg::create();
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
                    $src         = imagecreatefrompng($water_mark);
                    $dest        = imagecreatefromjpeg($result_image);
                    // Get dimensions
                    $imageWidth  = imagesx($dest);
                    $imageHeight = imagesy($dest);
                    $logoWidth   = imagesx($src);
                    $logoHeight  = imagesy($src);

                    imagecopy($dest, $src,($imageWidth-$logoWidth)/2,($imageHeight-$logoHeight)/2, 0, 0,$imageWidth, $imageHeight);

                    // Output and free from memory
                    imagejpeg($dest,$result_image);

                    imagedestroy($dest);
                    imagedestroy($src);
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
            echo "Got Cookie";
        }
    }

    //-------------------------------------------------------------------------

}
// //end of Thumbnail class
// // end of file Thumbnail.php