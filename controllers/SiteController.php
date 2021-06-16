<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\LanguageForm;
use app\models\UserSession;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['logout' => ['POST']],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        $model = new LanguageForm();
        $model->selected = Yii::$app->language;
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->language = $model->selected;
            Yii::$app->session->set('user.locale', $model->selected);
        }
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) return $this->goHome();

        $model        = new LoginForm();
        $sessionModel = new UserSession();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $sessionModel->user_id = Yii::$app->user->identity->id;

            if ($sessionModel->save()){
                Yii::$app->session->set('user.session_id', $sessionModel->id);
                return $this->goBack();
            }
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout()
    {
        $session_id = Yii::$app->session->get('user.session_id');
        if (Yii::$app->user->logout()) {
            $sessionModel = UserSession::findOne($session_id);
            $sessionModel->logout_timestamp = date('Y-m-d H:i:s');
            if ($sessionModel->save()) Yii::$app->session->set('user.session_id', null);
        }

        return $this->goHome();
    }

    /**
     * Register action
     * @return Response|string
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) { return $this->goBack(); }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {

            $userModel = User::find()
                ->select('accessToken')
                ->where(['main_email' => $model->main_email])
                ->one();
            Yii::$app->mailer->compose()
                ->setFrom('daniel.vasquez@tumi.com.pe')
                ->setTo($model->main_email)
                ->setSubject(Yii::t('app', 'Tumibets: Account registered'))
                ->setHtmlBody('<h2>TUMIBETS</h2>
                    <p>'. Yii::t('app', 'Your new account has been registered!') .'</p>
                    <p>'. Html::a(Yii::t('app', 'Validate your account here.'),
                    [Url::to(['site/validate']), 'accessToken' => $userModel->accessToken]) .'</p>')
                ->send();
            Yii::$app->session->setFlash('success', Yii::t('app', 'User account created successfully.'));

            return $this->redirect(['login']);
        }

        $model->password = '';
        $model->passwordConfirm = '';
        return $this->render('register', ['model' => $model]);
    }

    /**
     * Validates a user via accessToken in email link
     */
    public function actionValidate($accessToken)
    {
        $userModel = User::find()->where(['accessToken' => $accessToken])->one();
        if ($userModel === null) throw new NotFoundHttpException('The requested page does not exist.');
        
        $userModel->is_validated = TRUE;
        $didSave = $userModel->save();
        Yii::$app->session->setFlash(
            $didSave ? 'success' : 'error',
            Yii::t('app', $didSave
                ? 'User account validated successfully.'
                : 'User account could not be validated.'
            )
        );

        return $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Displays about page.
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
