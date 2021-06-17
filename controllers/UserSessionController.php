<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
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
                'class'      => AccessControl::className(),
                'ruleConfig' => ['class' => AccessRule::className()],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all UserSessionView models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $query  = UserSessionView::find()
            ->andFilterWhere([
                'id'       => $params['id']       ?? null,
                'is_admin' => $params['is_admin'] ?? null])
            ->andFilterWhere(['like', 'username', $params['username'] ?? null])
            ->andFilterWhere(['like', 'login_timestamp', $params['login_timestamp'] ?? null])
            ->andFilterWhere(['like', 'logout_timestamp', $params['logout_timestamp'] ?? null])
            ->orderBy('login_timestamp DESC');

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider(['query' => $query])
        ]);
    }

    /**
     * Displays a single UserSessionView model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = UserSessionView::findOne($id);
        if ($model === null) throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        return $this->render('view', ['model' => $model]);
    }

}
