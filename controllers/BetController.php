<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use app\models\Bet;
use app\models\BetView;
use app\models\FixtureView;
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
                'actions' => [
                    'delete' => ['POST'],
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
        $query = BetView::find()
            ->andFilterWhere([
                'id'            => $params['id']            ?? null,
                'is_active'     => $params['is_active']     ?? null])
            ->andFilterWhere(['like', 'name', $params['name'] ?? null])
            ->andFilterWhere(['like', 'user_created', $params['user_created'] ?? null])
            ->andFilterWhere(['like', 'time_created', $params['time_created'] ?? null])
            ->andFilterWhere(['like', 'user_updated', $params['user_updated'] ?? null])
            ->andFilterWhere(['like', 'time_updated', $params['time_updated'] ?? null]);

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider(['query' => $query]),
        ]);
    }

    /**
     * Displays a single Bet model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) { return $this->helperCRUD('view', $id); }

    /**
     * Creates a new Bet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() { return $this->helperCRUD('create'); }

    /**
     * Updates an existing Bet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) { return $this->helperCRUD('update', $id); }

    /**
     * Deletes an existing Bet model.
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
            'create' => 'Bet created succesfully.',
            'update' => 'Bet updated sucessfully.',
            'delete' => 'Bet deleted sucessfully.'
        ];
        Yii::$app->session->setFlash('success', Yii::t('app', $flashMessges[$action]));
    }

    /**
     * Gets dependencies
     */
    protected function getDependencies()
    {
        return ['fixtures' => FixtureView::find()->select(['id', 'name'])->all()];
    }

    /**
     * Helps render for CRUD actions.
     */
    protected function helperCRUD($action, $id = null)
    {
        //Find model
        switch ($action) {
            case 'view':   $model = BetView::findOne($id); break;
            case 'create': $model = new Bet(); break;
            default:       $model = Bet::findOne($id);
        }
        //Throw error if model not found
        if ($model === null) throw new NotFoundHttpException('The requested page does not exist.');

        //Handle actions
        switch ($action) {

            //Render view
            case 'view': return $this->render('view', ['model' => $model]);

            //Handle delete
            case 'delete':
                $model->delete();
                $this->setFlash('delete');
                return $this->redirect(['index']);

            //Handle & render create & update
            default:
                $dependencies = $this->getDependencies();

                if ($model->load(Yii::$app->request->post())) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    $model->image_path = md5($model->name) . '.' . $model->image->extension;

                    if ($model->save() && $model->image->saveAs(SITE_ROOT . '\\uploads\\tournamentImages\\' . $model->image_path)) {
                        $this->setFlash($action);
                        return $this->redirect(['index']);
                    }
                }
                return $this->render('_form', [
                    'action'  => $action,
                    'bet'     => $model,
                    'fixtures' => $dependencies['fixtures']
                ]);
        }
    }
}
