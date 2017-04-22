<?php 

namespace Lakshmaji\Thumbnail\Facade;

// Inlcude namespace 
use Illuminate\Support\Facades\Facade;
 
/**
 * Thumbnail - Facade to support integration with Laravel framework 
 *
 * @author     lakshmaji 
 * @package    Thumbnail
 * @version    1.4.2
 * @since      Class available since Release 1.0.0
 */ 
class Thumbnail extends Facade {
 
    protected static function getFacadeAccessor() { return 'thumbnail'; }
 
}
// end of class Thumbnail
// end of file Thumbnail.php