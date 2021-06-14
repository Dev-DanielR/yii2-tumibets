<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                'actions' => ['delete' => ['POST']]
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $query  = User::find()
            ->andFilterWhere([
                'id'           => $params['id']           ?? null,
                'is_active'    => $params['is_active']    ?? null,
                'is_validated' => $params['is_validated'] ?? null])
            ->andFilterWhere(['like', 'name', $params['name'] ?? null])
            ->andFilterWhere(['like', 'main_email', $params['main_email'] ?? null])
            ->andFilterWhere(['like', 'backup_email', $params['name'] ?? null]);

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider(['query' => $query])
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) { return $this->helperCRUD('view', $id); }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate() { return $this->helperCRUD('create'); }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) { return $this->helperCRUD('update', $id); }

    /**
     * Deletes an existing User model.
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
            'create' => 'User created succesfully.',
            'update' => 'User updated sucessfully.',
            'delete' => 'User deleted sucessfully.'
        ];
        Yii::$app->session->setFlash('success', Yii::t('app', $flashMessges[$action]));
    }

    /**
     * Helps render for CRUD actions.
     */
    protected function helperCRUD($action, $id = null)
    {
        //Find model
        switch ($action) {
            case 'create': $model = new User(); break;
            default:       $model = User::findOne($id);
        }
        //Throw error if model not found
        if ($model === null) throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

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
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $this->setFlash($action);
                    return $this->redirect(['index']);
                }
                return $this->render('_form', ['action' => $action, 'model' => $model]);
        }
    }
}
