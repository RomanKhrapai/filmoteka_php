namespace Palmo\Core\validation;

use Palmo\Core\service\ValidationRules;

class ValidateImage implements ValidationRules
{
use CommonValidation;

public static function validate($data)
{
return match (false) {
self::validateMaxSizeFile($data,30000) => "Size too large 30 Mb",
self::validateMinSizeFile($data,100) => "Size too litle 100 b",
self::validateTypeFile($data, []) => 'Invalid file type',
self::validateisFile($data) => 'the file is corrupted',
self::validateFileMinHeight($data,$minSize)=> 'the image is too small in height',
self::validateFileMinWidth($data, $minSize)=> 'the image is too small in width',
default => null
};
}
}