<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\LanguageForm;
use app\models\UserSession;
use app\models\ContactForm;

class SiteController extends Controller
{
    static $flashMessages = [
        'register' => 'User account created successfully.'
    ];

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
        //if (!Yii::$app->user->isGuest) { return $this->goBack(); }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success',
                Yii::t('app', static::$flashMessages['register']));
            return $this->render('login', ['model' => new LoginForm()]);
        }

        $model->password = '';
        $model->passwordConfirm = '';
        return $this->render('register', ['model' => $model]);
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
