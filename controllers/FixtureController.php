<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\Fixture;
use app\models\Tournament;
use app\models\TournamentDate;
use app\models\Team;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FixtureController implements the CRUD actions for Fixture model.
 */
class FixtureController extends Controller
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
                    'index'  => ['GET', 'POST'],
                    'view'   => ['POST'],
                    'create' => ['POST'],
                    'update' => ['POST'],
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Fixture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params       = Yii::$app->request->post();
        $navigation   = $this->findNavigationModels($params['tournament_date_id'] ?? null);
        $dataProvider = $this->search($params);
        return $this->render('index', [
            'tournament'      => $navigation['tournament'],
            'tournament_date' => $navigation['tournament_date'],
            'dataProvider'    => $dataProvider
        ]);
    }

    /**
     * Displays a single Fixture model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $id         = Yii::$app->request->post('id');
        $model      = $this->findModel($id);
        $navigation = $this->findNavigationModels($model->tournament_date_id);
        return $this->render('view', [
            'tournament'      => $navigation['tournament'],
            'tournament_date' => $navigation['tournament_date'],
            'fixture'         => $model
        ]);
    }

    /**
     * Creates a new Fixture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model  = new Fixture();
        $params = Yii::$app->request->post();
        $model->tournament_date_id = $params['tournament_date_id'] ?? null;
        return $this->helperForm($model, 'create', 'Create Fixture');
    }

    /**
     * Updates an existing Fixture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $id    = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->datesToReadFormat();
        return $this->helperForm($model, 'update', 'Update Fixture: ' . $model->teamA->name . ' vs ' . $model->teamB->name);
    }

    /**
     * Deletes an existing Fixture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Fixture deleted successfully.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Fixture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fixture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fixture::find()
            ->with(['teamA', 'teamB'])
            ->andFilterWhere(['id' => $id])
            ->one()) !== null) return $model;
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds models for navigation
     * @return [Tournament, Tournament_Date]
     */
    protected function findNavigationModels($id)
    {
        $tournament_date = null;
        $tournament      = null;
        if ($id !== null) {
            $tournament_date = TournamentDate::find()->select(['id', 'name', 'tournament_id'])->where(['id' => $id])->one();
            $tournament = Tournament::find()->select(['id', 'name'])->where(['id' => $tournament_date->tournament_id])->one();
        }
        return [
            'tournament'      => $tournament,
            'tournament_date' => $tournament_date
        ];
    }

    /**
     * Finds models for dependencies
     * @return [Tournament_Date[], Team[]]
     */
    protected function findDependencyModels($id)
    {
        return [
            'tournament_dates' => TournamentDate::find()->select(['id', 'name'])->andFilterWhere(['id' => $id])->all(),
            'teams'            => Team::find()->select(['id', 'name'])->all()
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = Fixture::find()->with(['tournamentDate', 'teamA', 'teamB']);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'                 => $params['id']                 ?? null,
            'tournament_date_id' => $params['tournament_date_id'] ?? null,
            'teamA_id'           => $params['teamA_id']           ?? null,
            'teamB_id'           => $params['teamB_id']           ?? null,
            'teamA_score'        => $params['teamA_score']        ?? null,
            'teamB_score'        => $params['teamB_score']        ?? null,
            'start'              => $params['start']              ?? null,
            'end'                => $params['end']                ?? null,
            'is_active'          => $params['is_active']          ?? null
        ]);
        return $dataProvider;
    }

    /**
     * Helps render form for Create & Update actions.
     */
    protected function helperForm($model, $actionName, $formTitle)
    {
        $navigation   = $this->findNavigationModels($model->tournament_date_id);
        $dependencies = $this->findDependencyModels($model->tournament_date_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Fixture " . $actionName . "d successfully.");
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
            'formTitle'        => $formTitle,
            'actionName'       => $actionName,
            'tournament'       => $navigation['tournament'],
            'tournament_date'  => $navigation['tournament_date'],
            'fixture'          => $model,
            'tournament_dates' => $dependencies['tournament_dates'],
            'teams'            => $dependencies['teams']
        ]);
    }
}
