<?php
namespace App\Modules\Model\Models;
use App\Modules\Api\Models\PerformerModel;

/**
 * The model to store tag for performer
 * @property integer performerId
 * @property string tag
 *
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class PerformerTag extends Model {
  protected $table = 'performer_tags';

  public function save(array $options = []) {
    parent::save($options);

    $this->_updatePerformerTag();
  }

  /**
   *
   */
  protected function _updatePerformerTag() {
    //get all performer tags and update into performer row
    $tags = self::where([
      'performerId' => $this->performerId
    ])->get();
    $text = [];
    foreach($tags as $tag) {
      $text[] = $tag->tag;
    }
    PerformerModel::where(['id' => $this->performerId])->update(['tags' => json_encode(text)]);
  }

  public static function updateTags($performerId, $tags) {
    //n-n relation, we will remove all old tags then insert a batch file
    self::where([
      'performerId' => $performerId
    ])->delete();

    $data = [];
    if (!is_array($tags)) {
      $tags = explode(',', $tags);
    }

    foreach ($tags as $tag) {
      if (($tagTrim = trim($tag))) {
        $data[] = [
          'tag' => $tag,
          'performerId' => $performerId
        ];
      }
    }

    self::insert($data);
  }
}
