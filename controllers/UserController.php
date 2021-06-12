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
    static $flashMessges = [
        'create' => 'User created succesfully.',
        'update' => 'User updated sucessfully.',
        'delete' => 'User deleted sucessfully.'
    ];

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
        $dataProvider = $this->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        return $this->helperForm('create', $model);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->helperForm('update', $model);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "User deleted successfully.");
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = User::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'           => $params['id']           ?? null,
            'is_active'    => $params['is_active']    ?? null,
            'is_validated' => $params['is_validated'] ?? null,
        ]);
        $query->andFilterWhere(['like', 'name', $params['name'] ?? null]);
        $query->andFilterWhere(['like', 'main_email', $params['main_email'] ?? null]);
        $query->andFilterWhere(['like', 'backup_email', $params['name'] ?? null]);
        return $dataProvider;
    }

    /**
     * Helps render form for Create & Update actions.
     */
    protected function helperForm($action, $model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success',
                Yii::t('app', static::$flashMessages[$action]));
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
            'action' => $action,
            'model'  => $model
        ]);
    }
}
