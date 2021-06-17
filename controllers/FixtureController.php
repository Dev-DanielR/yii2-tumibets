<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use app\models\Fixture;
use app\models\FixtureView;
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
                'class'      => AccessControl::className(),
                'ruleConfig' => ['class' => AccessRule::className()],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['delete' => ['POST']]
            ],
        ];
    }

    /**
     * Lists all Fixture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        if (!isset($params['tournament_date_id']))
            throw new NotFoundHttpException('The requested page does not exist.');

        $hierarchy = $this->getHierarchy($params['tournament_date_id']);
        $query = FixtureView::find()
            ->andFilterWhere([
                'tournament_id'      => $params['tournament_id']      ?? null,
                'tournament_date_id' => $params['tournament_date_id'] ?? null,
                'id'                 => $params['id']                 ?? null,
                'teamA_id'           => $params['teamA_id']           ?? null,
                'teamA_score'        => $params['teamA_score']        ?? null,
                'teamB_id'           => $params['teamB_id']           ?? null,
                'teamB_score'        => $params['teamB_score']        ?? null,
                'start'              => $params['start']              ?? null,
                'end'                => $params['end']                ?? null,
                'is_active'          => $params['is_active']          ?? null,
                'bet_count'          => $params['bet_count']          ?? null,
            ])
            ->andFilterWhere(['like', 'tournament', $params['tournament'] ?? null])
            ->andFilterWhere(['like', 'tournament_date', $params['tournament_date'] ?? null])
            ->andFilterWhere(['like', 'name', $params['name'] ?? null])
            ->andFilterWhere(['like', 'teamA', $params['teamA'] ?? null])
            ->andFilterWhere(['like', 'teamB', $params['teamB'] ?? null])
            ->andFilterWhere(['like', 'user_created', $params['user_created'] ?? null])
            ->andFilterWhere(['like', 'time_created', $params['time_created'] ?? null])
            ->andFilterWhere(['like', 'user_updated', $params['user_updated'] ?? null])
            ->andFilterWhere(['like', 'time_updated', $params['time_updated'] ?? null]);

        return $this->render('index', [
            'tournament'      => $hierarchy['tournament'],
            'tournament_date' => $hierarchy['tournament_date'],
            'dataProvider'    => new ActiveDataProvider(['query' => $query])
        ]);
    }

    /**
     * Displays a single Fixture model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) { return $this->helperCRUD('view', $id); }

    /**
     * Creates a new Fixture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() { return $this->helperCRUD('create'); }

    /**
     * Updates an existing Fixture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id) { return $this->helperCRUD('update', $id); }

    /**
     * Deletes an existing Fixture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) { return $this->helperCRUD('delete', $id); }

    /**
     * Set session flash.
     */
    protected function setFlash($action)
    {
        $flashMessges = [
            'create' => 'Fixture created succesfully.',
            'update' => 'Fixture updated sucessfully.',
            'delete' => 'Fixture deleted sucessfully.'
        ];
        Yii::$app->session->setFlash('success', Yii::t('app', $flashMessges[$action]));
    }

    /**
     * Gets hierarchy data for navigation
     */
    protected function getHierarchy($id)
    {
        $tournament_date = TournamentDate::find()->select(['id', 'name', 'tournament_id'])->where(['id' => $id])->one();
        $tournament      = Tournament::find()->select(['id', 'name'])->where(['id' => $tournament_date->tournament_id])->one();
        return [
            'tournament'      => $tournament,
            'tournament_date' => $tournament_date
        ];
    }

    /**
     * Gets dependencies
     */
    protected function getDependencies()
    {
        return [
            'teams' => Team::find()->select(['id', 'name'])->all()
        ];
    }

    /**
     * Helps render for CRUD actions.
     */
    protected function helperCRUD($action, $id = null)
    {
        //Get Model
        switch ($action) {

            //Find view model
            case 'view': $model = FixtureView::findOne($id); break;

            //Create model and set tournament date
            case 'create':
                $params = Yii::$app->request->queryParams;
                if (!isset($params['tournament_date_id']))
                    throw new NotFoundHttpException('The requested page does not exist.');

                $model  = new Fixture();
                $model->tournament_date_id = $params['tournament_date_id'];
                break;

            //Find model
            default: $model = Fixture::findOne($id);
        }
        if ($model === null) throw new NotFoundHttpException('The requested page does not exist.');

        //Handle actions
        switch ($action) {

            //Handle view
            case 'view': return $this->render('view', ['model' => $model]);

            //Handle delete
            case 'delete':
                $model->delete();
                $this->setFlash('delete');
                return $this->redirect(['index', 'tournament_date_id' => $model->tournament_date_id]);

            //Handle create & update
            default:
                $hierarchy    = $this->getHierarchy($model->tournament_date_id);
                $dependencies = $this->getDependencies();

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $this->setFlash($action);
                    Yii::$app->mailer->compose()
                        ->setFrom('daniel.vasquez@tumi.com.pe')
                        ->setTo($model->userCreated->main_email)
                        ->setSubject(Yii::t('email', 'Tumibets: Fixture ' . $action . 'd'))
                        ->setHtmlBody('<h2>TUMIBETS</h2>
                            <p>'. Yii::t('email', 'A fixture was ' . $action . 'd for') . ': ' . $model->name .'</p>
                            <p>'. Html::a(Yii::t('email', 'Check the fixture here.'),
                            [Url::to(['fixture/view']), 'id' => $model->id]) .'</p>')
                        ->send();
                    return $this->redirect(['index', 'tournament_date_id' => $model->tournament_date_id]);
                }

                if ($action === 'update'){ $model->datesToReadFormat(); }
                return $this->render('_form', [
                    'action'           => $action,
                    'tournament'       => $hierarchy['tournament'],
                    'tournament_date'  => $hierarchy['tournament_date'],
                    'fixture'          => $model,
                    'teams'            => $dependencies['teams']
                ]);
        }
    }
}
