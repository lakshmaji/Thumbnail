# Thumbnail
Thumbnail for a given video using FFMpeg

Run
composer require lakshmajim/thumbnail
add to 'providers' array
        Lakshmajim\Thumbnail\ThumbnailServiceProvider::class,

add to 'aliases' array
        'Thumbnail' => Lakshmajim\Thumbnail\Facade\Thumbnail::class,

do composer update

use Thumbnail;

$thumbnail_status = Thumbnail::getThumbnail(<VIDEO_SOURCE_DIRECTORY>,<THUMBNAIL_STORAGE_DIRECTORY>,<THUMBNAIL_NAME>);

<THUMBNAIL_NAME> formats .jpg, .png

System dependencies (FFMpeg)
1.on Ubuntu

  Add the mc3man ppa
  sudo add-apt-repository ppa:mc3man/trusty-media
  
  Run following two commands to Update the package list.
  sudo apt-get update
  sudo apt-get dist-upgrade
  
  Now FFmpeg is available to be installed with apt
  Run following command to install FFMpeg
  sudo apt-get install ffmpeg
