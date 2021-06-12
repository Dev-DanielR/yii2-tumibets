<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\models\Tournament;
use app\models\TournamentView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $params = Yii::$app->request->queryParams;
        $query  = TournamentView::find()
            ->andFilterWhere([
                'id'        => $params['id']            ?? null,
                'is_active' => $params['is_active']     ?? null])
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
     * Displays a single Tournament model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) { return $this->helperCRUD('view', $id); }

    /**
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() { return $this->helperCRUD('create'); }

    /**
     * Updates an existing Tournament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) { return $this->helperCRUD('update', $id); }

    /**
     * Deletes an existing Tournament model.
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
            'create' => 'Tournament created succesfully.',
            'update' => 'Tournament updated sucessfully.',
            'delete' => 'Tournament deleted sucessfully.'
        ];
        Yii::$app->session->setFlash('success', Yii::t('app', $flashMessges[$action]));
    }

    /**
     * Helps render for CRUD actions.
     */
    protected function helperCRUD($action, $id = NULL)
    {
        //Find model
        switch ($action) {
            case 'view':   $model = TournamentView::findOne($id); break;
            case 'create': $model = new Tournament(); break;
            default:       $model = Tournament::findOne($id);
        }
        //Throw error if model not found
        if ($model === NULL) throw new NotFoundHttpException('The requested page does not exist.');

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
                if ($model->load(Yii::$app->request->post())) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    $model->image_path = md5($model->name) . '.' . $model->image->extension;

                    if ($model->save() && $model->image->saveAs(SITE_ROOT .
                        '\\uploads\\tournamentImages\\' . $model->image_path)) {
                            $this->setFlash($action);
                        return $this->redirect(['index']);
                    }
                }
                return $this->render('_form', ['action' => $action, 'model' => $model]);
        }
    }
}
