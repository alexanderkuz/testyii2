<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property integer $name_id
 * @property string $code
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_id', 'code'], 'required'],
            [['name_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_id' => 'Родитель',
            'code' => 'Коды',
        ];
    }

    /**
     * @inheritdoc
     * @return CodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CodeQuery(get_called_class());
    }
}
