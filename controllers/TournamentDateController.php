<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use app\models\Tournament;
use app\models\TournamentDate;
use app\models\TournamentDateView;
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
     * Lists all TournamentDate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        if (!isset($params['tournament_id']))
            throw new NotFoundHttpException('The requested page does not exist.');

        $hierarchy = $this->getHierarchy($params['tournament_id']);
        $query = TournamentDateView::find()
            ->andFilterWhere([
                'id'            => $params['id']        ?? null,
                'is_active'     => $params['is_active'] ?? null
            ])
            ->andFilterWhere(['like', 'name', $params['name'] ?? null])
            ->andFilterWhere(['like', 'tournament', $params['tournament'] ?? null])
            ->andFilterWhere(['like', 'user_created', $params['user_created'] ?? null])
            ->andFilterWhere(['like', 'time_created', $params['time_created'] ?? null])
            ->andFilterWhere(['like', 'user_updated', $params['user_updated'] ?? null])
            ->andFilterWhere(['like', 'time_updated', $params['time_updated'] ?? null]);

        return $this->render('index', [
            'tournament'   => $hierarchy['tournament'],
            'dataProvider' => new ActiveDataProvider(['query' => $query])
        ]);
    }

    /**
     * Displays a single TournamentDate model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) { return $this->helperCRUD('view', $id); }

    /**
     * Creates a new TournamentDate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() { return $this->helperCRUD('create'); }

    /**
     * Updates an existing TournamentDate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) { return $this->helperCRUD('update', $id); }

    /**
     * Deletes an existing TournamentDate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
            'create' => 'Tournament Date created succesfully.',
            'update' => 'Tournament Date updated sucessfully.',
            'delete' => 'Tournament Date deleted sucessfully.'
        ];
        Yii::$app->session->setFlash('success', Yii::t('app', $flashMessges[$action]));
    }

    /**
     * Gets hierarchy data for navigation
     */
    protected function getHierarchy($id)
    {
        return ['tournament' => Tournament::findOne($id)];
    }

    /**
     * Helps render for CRUD actions.
     */
    protected function helperCRUD($action, $id = null)
    {
        //Get model
        switch ($action) {

            //Find view model
            case 'view': $model = TournamentDateView::findOne($id); break;

            //Create model and set tournament
            case 'create':
                $params = Yii::$app->request->queryParams;
                if (!isset($params['tournament_id']))
                    throw new NotFoundHttpException('The requested page does not exist.');

                $model = new TournamentDate();
                $model->tournament_id = $params['tournament_id'];
                break;

            //Find model
            default: $model = TournamentDate::findOne($id);
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
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);

            //Handle create & update
            default:
                $hierarchy = $this->getHierarchy($model->tournament_id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $this->setFlash($action);
                    return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
                }

                return $this->render('_form', [
                    'action'          => $action,
                    'tournament'      => $hierarchy['tournament'],
                    'tournament_date' => $model
                ]);
        }
    }
}
