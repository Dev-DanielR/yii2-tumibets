<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\models\Bet;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BetController implements the CRUD actions for Bet model.
 */
class BetController extends Controller
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
     * Lists all Bet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->search(Yii::$app->request->post());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single Bet model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $id = Yii::$app->request->post('id');
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new Bet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bet();
        return $this->helperForm($model, 'create', 'Create Bet');
    }

    /**
     * Updates an existing Bet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $id    = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        return $this->helperForm($model, 'update', 'Update Bet: ' . $model->id);
    }

    /**
     * Deletes an existing Bet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Bet deleted successfully.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Bet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bet::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds models for dependencies
     * @return [Fixtures[]]
     */
    protected function findDependencyModels()
    {
        return [
            'fixtures' => Yii::$app->db
                ->createCommand("SELECT f.id, CONCAT(a.name, ' vs ', b.name) AS name FROM fixture f
                    INNER JOIN team a ON f.teamA_id = a.id
                    INNER JOIN team b ON f.teamB_id = b.id;")
                ->queryAll()
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = Bet::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'          => $params['id']          ?? null,
            'fixture_id'  => $params['fixture_id']  ?? null,
            'user_id'     => $params['user_id']     ?? null,
            'teamA_score' => $params['teamA_score'] ?? null,
            'teamB_score' => $params['teamB_score'] ?? null,
            'bet_score'   => $params['bet_score']   ?? null,
            'is_active'   => $params['is_active']   ?? null,
            'created'     => $params['created']     ?? null,
            'updated'     => $params['updated']     ?? null,
        ]);
        return $dataProvider;
    }

    /**
     * Helps render form for Create & Update actions.
     */
    protected function helperForm($model, $actionName, $formTitle)
    {
        $dependencies = $this->findDependencyModels();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Bet ' . $actionName . 'd successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
            'formTitle'  => $formTitle,
            'actionName' => $actionName,
            'bet'        => $model,
            'fixtures'   => $dependencies['fixtures']
        ]);
    }
}
