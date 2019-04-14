<?php
namespace App\Helpers;

/**
 * Description of String
 *
 * @author tuongtran
 */
class StringHelper {
  public static function tagsStringToArray($tags) {
    $data = [];
    $tags = explode(',', $tags);
    foreach ($tags as $tag) {
      if (($tagTrim = trim($tag))) {
        $data[] = $tagTrim;
      }
    }

    return $data;
  }
}
