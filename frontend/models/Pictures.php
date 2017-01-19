<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Pictures is the model for pictures load and rotate.
 */
class Pictures extends \yii\db\ActiveRecord
{
  public $file;
    public static function tableName()
    {
        return 'pictures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
          [['user_id', 'picture'], 'required'],
          [['file'], 'file'], //, 'extensions' => 'gif, jpg'
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'picture' => 'Picture path',
        ];
    }

}
