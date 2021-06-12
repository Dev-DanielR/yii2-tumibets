<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\models\UserSessionView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserSessionController implements the CRUD actions for UserSessionView model.
 */
class UserSessionController extends Controller
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
     * Lists all UserSessionView models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single UserSessionView model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Finds the UserSessionView model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserSessionView the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserSessionView::findOne($id)) !== null) return $model;
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    protected function search($params)
    {
        $query        = UserSessionView::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $query->andFilterWhere([
            'id'       => $params['id']       ?? null,
            'is_admin' => $params['is_admin'] ?? null,
        ]);
        $query->andFilterWhere(['like', 'username', $params['username'] ?? null]);
        $query->andFilterWhere(['like', 'login_timestamp', $params['login_timestamp'] ?? null]);
        $query->andFilterWhere(['like', 'logout_timestamp', $params['logout_timestamp'] ?? null]);
        $query->orderBy('login_timestamp DESC');
        return $dataProvider;
    }
}
