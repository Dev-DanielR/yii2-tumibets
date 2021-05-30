<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\Tournament;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TournamentController implements the CRUD actions for Tournament model.
 */
class TournamentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'  => ['POST'],
                    'view'   => ['POST'],
                    'create' => ['POST'],
                    'update' => ['POST'],
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Tournament models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->search(Yii::$app->request->post());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single Tournament model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $id = Yii::$app->request->post('id');
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tournament();
        return $this->helperForm($model, 'create', 'Create Tournament');
    }

    /**
     * Updates an existing Tournament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $id    = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        return $this->helperForm($model, 'update', 'Update Tournament: ' . $model->name);
    }

    /**
     * Deletes an existing Tournament model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Tournament deleted successfully.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Tournament model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tournament the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tournament::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = Tournament::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'        => $params['id']            ?? null,
            'is_active' => $params['is_active']     ?? null,
        ],['like', 'name', $params['name'] ?? null]);
        return $dataProvider;
    }

    /**
     * Helps render form for Create & Update actions.
     */
    protected function helperForm($model, $actionName, $formTitle)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tournament ' . $actionName . 'd successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
            'formTitle'  => $formTitle,
            'actionName' => $actionName,
            'model'      => $model
        ]);
    }
}
