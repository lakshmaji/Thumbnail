# Thumbnail



[Wiki on web](http://lakshmajim.github.io/Thumbnail/)

>### INDEX

|Index|Description|
|---|---|
|[What it is](https://github.com/lakshmajim/Thumbnail#what-it-is) |- Introduction|
|[Installing FFMpeg](https://github.com/lakshmajim/Thumbnail#installing-dependency-software) |- Installing dependency software|
|[Installation](https://github.com/lakshmajim/Thumbnail#installation) |- Installing Thumbnail package, Lararavel Integration|
|[Docs](https://github.com/lakshmajim/Thumbnail#method)|- Methods and Description|
|[Generating Thumbnail](https://github.com/lakshmajim/Thumbnail#genearting-thumbnail) |- Generateing thumbnail image with this package|
|[Miscellaneous](https://github.com/lakshmajim/Thumbnail#miscellaneous) |- Miscellaneous content regarding method calls|
|[Twilio](https://github.com/lakshmajim/Thumbnail#license) |- License Information|



>### What it is

 - Generates Thumbnail (image) for a given video 
 - This uses **FFMpeg**.

>### Version

1.0.0

---
>### Installing dependency software

This package relays on [FFMpeg](https://en.wikipedia.org/wiki/FFmpeg), A complete, cross-platform solution to record, convert and stream audio and video i.e, Multimedia .

####Installing FFMpeg on Ubuntu

- Add the mc3man ppa

```bash
    sudo add-apt-repository ppa:mc3man/trusty-media
```
        
- Run following command to Update the package list. 

```bash
    sudo apt-get update
    sudo apt-get update sudo apt-get dist-upgrade
```
        
- Now FFmpeg is available to be installed with **apt** , Run this command

```terminal
	sudo apt-get install ffmpeg
```

####Installing FFMpeg on CentOS 
- Enable EPEL repository 
   - for centos 6
     
     ```bash
        rpm -Uvh http://mirrors.kernel.org/fedora-epel/6/i386/epel-release-6-8.noarch.rpm
     ```
   - for centos 5
     
     ```bash
        rpm -Uvh http://mirrors.kernel.org/fedora-epel/5/i386/epel-release-5-4.noarch.rpm
     ```
   - for centos 7
     
     ```bash
        yum install epel-release
     ```

- Check whether EPEL respository is eabled by the following command

  ```bas
     yum repolist
  ```

- Import the official GPG key of Nux Dextop repository:

  ```bash
     rpm --import http://li.nux.ro/download/nux/RPM-GPG-KEY-nux.ro
  ```
   
   
#####Nux Dextop is a third-party RPM repository which contains many popular desktop and multimedia related packages (e.g., Ardour, Shutter, etc) for CentOS, RHEL and ScientificLinux. Currently, Nux Dextop repository is available for CentOS/RHEL 6 and 7.
   
   
- Install Nux Dextop with yum command as follows.
    - centos 6
    
      ```bash
      rpm -Uvh http://li.nux.ro/download/nux/dextop/el6/x86_64/nux-dextop-release-0-2.el6.nux.noarch.rpm
      ```
    - centos 7
    
      ```bash
      rpm -Uvh http://li.nux.ro/download/nux/dextop/el7/x86_64/nux-dextop-release-0-1.el7.nux.noarch.rpm
      ```
    
- Now verify that Nux Dextop repository is successfully installed:
    
    ```bash
       yum repolist
    ```
    
- Run following command to install FFMpeg
    
    ```bash
       yum install ffmpeg
    ```
    
    

####Installing FFMpeg on Windows

 Refer to the following links
 
 [WikiHow](http://www.wikihow.com/Install-FFmpeg-on-Windows) 

 [AdapticeSolutions](http://adaptivesamples.com/how-to-install-ffmpeg-on-windows/)

        
---
>### Installation

- This package is available on packagist
```bash
    composer require lakshmajim/thumbnail
```
- Add the Service Provider to **providers** array
```php
Lakshmajim\Thumbnail\ThumbnailServiceProvider::class,
```
- Add the Facade to **aliases** array
```php
'Thumbnail' => Lakshmajim\Thumbnail\Facade\Thumbnail::class,
```
- Try updating the application with composer (dependencies)
    ```bash
    composer update
    ```
---

>### Genearting Thumbnail

The following example illustrates the usage of Thumbnail package
```php
<?php 

namespace Trending\Http\Controllers\File;

use Carbon;
use Thumbnail;
use Illuminate\Http\Request;
use Trending\Http\Controllers\Controller;


/**
 * -----------------------------------------------------------------------------
 *   ThumbnailTest - a class illustarting the usage og Thumbnail package 
 * -----------------------------------------------------------------------------
 * This class having the functionality to upload a video file 
 * and generate corresponding thumbnail
 *
 * @since    1.0.0
 * @version  1.0.0
 * @author   lakshmajim 
 */
class ThumbnailTest extends AnotherClass
{
	public function testThumbnail()
	{
		// get file from input data
		$file             = $this->request->file('file');

		// get file type
		$extension_type   = $file->getClientMimeType();
		
		// set storage path to store the file (actual video)
		$destination_path = storage_path().'/uploads';

		// get file extension
		$extension        = $file->getClientOriginalExtension();


		$timestamp        = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		$file_name        = $timestamp;
		
		$upload_status    = $file->move($destination_path, $file_name);	        

		if($upload_status)
		{
			// file type is video
			// set storage path to store the file (image generated for a given video)
			$thumbnail_path   = storage_path().'/images';

			$video_path       = $destination_path.'/'.$file_name;

			// set thumbnail image name
			$thumbnail_image  = $fb_user_id.".".$timestamp.".jpg";
			
			// set the thumbnail image "palyback" video button
			$water_mark       = storage_path().'/watermark/p.png';

			// get video length and process it
			// assign the value to time_to_image (which will get screenshot of video at that specified seconds)
			$time_to_image    = floor(($data['video_length'])/2);


			$thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,160,128,$time_to_image,$water_mark,true);		
			if($thumbnail_status)
			{
				echo "Thumbnail generated";
			}
			else
			{
				echo "thumbnail generation has failed";
			}
		}
	}
}
// end of class ThumbnailTest
// end of file ThumbnailTest.php  
```

---
>### METHOD

```php
$thumbnail_status = Thumbnail::getThumbnail(<VIDEO_SOURCE_DIRECTORY>,<THUMBNAIL_STORAGE_DIRECTORY>,<THUMBNAIL_NAME>);
```

```php
$thumbnail_status = Thumbnail::getThumbnail(<VIDEO_SOURCE_DIRECTORY>,<THUMBNAIL_STORAGE_DIRECTORY>,<THUMBNAIL_NAME>,<HEIGHT_OF_IMAGE>,<WIDTH_OF_IMAGE>,<TIME_TO_TAKE_SCREENSHOT>,<WATERMARK_SOURCE_PATH>,<WATER_MARK>);

```

| PARAMETER           | DESCRIPTION                             |FIELD |
|:-------------- |:----------------------------------------|:---|
|VIDEO_SOURCE_DIRECTORY |     Video resource source path i.e, the name of video along with location where video is present|mandatory| 
| THUMBNAIL_STORAGE_DIRECTORY|    The destination path to save the generated thumbnail image|mandatory|
| THUMBNAIL_NAME | The name of Image for output|mandatory|
|HEIGHT_OF_IMAGE           |The height of output image             |  optional|
 | WIDTH_OF_IMAGE|       The width of output image                 |  optional|
| TIME_TO_TAKE_SCREENSHOT    |         Time to take screenshot of the video               | optional|
| WATERMARK_SOURCE_PATH| The name of watermark or play button along with the storage path | optional|
 |WATER_MARK         |     if this value set to true then it inserts play button or watermark on thumbnail image| optional|
|THUMBNAIL_IMAGE_WIDTH|The height of thumbnail image with watermark|mandatory|
|THUMBNAIL_IMAGE_HEIGHT|The width of Thumbnail image with watermark |mandatory|

**Note** The final output thumbnail image dimensions must be specified in **.env** file.
```bash
THUMBNAIL_IMAGE_WIDTH  = 320
THUMBNAIL_IMAGE_HEIGHT = 240
```
This ensures that all the generated thumbnails with watermarks are having fixed dimensions

----
>### MISCELLANEOUS

- To generate the thumbnail image ( screen shot of video)
```php
Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,160,128,$time_to_image,$water_mark,false);
```

- To generate the thumbnail image with watermark (play button)
```php
Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,160,128,$time_to_image,$water_mark,true);
```
----
>### LICENSE

[MIT](https://opensource.org/licenses/MIT)
