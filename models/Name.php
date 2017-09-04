<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\models\Code;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "name".
 *
 * @property integer $id
 * @property string $created_date
 * @property string $updated_date
 * @property string $name
 * @property string $title
 * @property string $body
 */
class Name extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'name';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['name', 'title'], 'string', 'max' => 255],

            ['body', 'match', 'pattern' => '#^(\{([+-]?\d+|[+-]?\d+\.?\d*)\})+$#','message' => 'не правельный формат расчета']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_date' => 'Дата создания',
            'updated_date' => 'Дата измения',
            'name' => 'Имя пользователя',
            'title' => 'Название расчета',
            'body' => 'Расчет',
        ];
    }

    /**
     * @inheritdoc
     * @return NameQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NameQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Code::className(), ['name_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getCodes()
    {
        $model=Code::find()->select(['code'])->where('name_id=:id',[':id'=>$this->id])->asArray()->all();
        return  implode ( ', ',ArrayHelper::getColumn($model, 'code'));
    }
}
