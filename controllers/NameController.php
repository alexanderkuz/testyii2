<?php

namespace app\controllers;

use Yii;
use app\models\Name;
use app\models\Code;
use app\models\NameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NameController implements the CRUD actions for Name model.
 */
class NameController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Name models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Name model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Name model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Name();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            $codes=preg_split('#[}{]#', $model->body, NULL ,PREG_SPLIT_NO_EMPTY) ;

            foreach ($codes as $val)
            {
                $code=new Code();
                $code->name_id=$model->id;
                $code->code=$val;
                $code->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Name model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Code::deleteAll(['name_id' => $id]);
            $codes=preg_split('#[}{]#', $model->body, NULL ,PREG_SPLIT_NO_EMPTY) ;

            foreach ($codes as $val)
            {
                $code=new Code();
                $code->name_id=$id;
                $code->code=$val;
                $code->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Name model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Code::deleteAll(['name_id' => $id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Name model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Name the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Name::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошенная страница не существует.');
        }
    }
}
