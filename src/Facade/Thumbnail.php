<?php namespace Lakshmajim\Thumbnail\Facade;
 
use Illuminate\Support\Facades\Facade;
 
/**
 * Thumbnail - Facade to support integration with Laravel framework 
 *
 * @author     lakshmaji 
 * @package    Thumbnail
 * @version    1.4.0
 * @since      Class available since Release 1.0.0
 */ 
class Thumbnail extends Facade {
 
    protected static function getFacadeAccessor() { return 'thumbnail'; }
 
}
// end of class Thumbnail
// end of file Thumbnail.php