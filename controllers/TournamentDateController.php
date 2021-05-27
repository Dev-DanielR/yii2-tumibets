<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\Tournament;
use app\models\TournamentDate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TournamentDateController implements the CRUD actions for TournamentDate model.
 */
class TournamentDateController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TournamentDate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params       = Yii::$app->request->getQueryParams();
        $navigation   = $this->findNavigationModels($params['tournament_id'] ?? null);
        $dataProvider = $this->search($params);
        return $this->render('index', [
            'tournament'   => $navigation['tournament'],
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single TournamentDate model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model      = $this->findModel($id);
        $navigation = $this->findNavigationModels($model->tournament_id);
        return $this->render('view', [
            'tournament'       => $navigation['tournament'],
            'tournament_date'  => $model,
        ]);
    }

    /**
     * Creates a new TournamentDate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model  = new TournamentDate();
        $params = Yii::$app->request->getQueryParams();
        $model->tournament_id = $params['tournament_id'] ?? null;
        return $this->helperForm($model, 'create', 'Create Tournament Date');
    }

    /**
     * Updates an existing TournamentDate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->helperForm($model, 'update', 'Update Tournament Date: ' . $model->name);
    }

    /**
     * Deletes an existing TournamentDate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Tournament date deleted successfully.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the TournamentDate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TournamentDate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TournamentDate::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds models for navigation
     * @return [Tournament]
     */
    protected function findNavigationModels($id)
    {
        return [
            'tournament' => Tournament::find()->select(['id', 'name'])->where(['id' => $id])->one()
        ];
    }

    /**
     * Finds models for dependencies
     * @return [Tournament[]]
     */
    protected function findDependencyModels()
    {
        return [
            'tournaments' => Tournament::find()->select(['id', 'name'])->all()
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = TournamentDate::find()->with('tournament');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'            => $params['id']            ?? null,
            'tournament_id' => $params['tournament_id'] ?? null,
            'is_active'     => $params['is_active']     ?? null,
        ],['like', 'name', $params['name'] ?? null]);
        return $dataProvider;
    }

    /**
     * Helps render form for Create & Update actions.
     */
    protected function helperForm($model, $actionName, $formTitle)
    {
        $navigation   = $this->findNavigationModels($model->tournament_id);
        $dependencies = $this->findDependencyModels();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Tournament date ' . $actionName .'d successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
            'formTitle'       => $formTitle,
            'actionName'      => $actionName,
            'tournament'      => $navigation['tournament'],
            'tournament_date' => $model,
            'tournaments'     => $dependencies['tournaments']
        ]);
    }
}
