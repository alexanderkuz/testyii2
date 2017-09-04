<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="name-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать расчет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_date',
            'updated_date',
            'name',
            'title',
            'body:ntext',
            [
                'format' => 'ntext',
                'label' => 'Коды',
                'value'=>function($data) {  return $data->getCodes(); },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
