<?php

namespace app\controllers;

use Yii;
use Yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Tournament;
use app\models\TournamentDate;
use app\models\Fixture;
use app\models\BetForm;
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

        $tournament = Tournament::find()->where(['is_active' => 1])->one();
        $tournament_date = TournamentDate::find()->where([
            'is_active'     => 1,
            'tournament_id' => $tournament->id
        ])->one();
        $tournament_dates = TournamentDate::find()->where([
            'is_active'     => 0,
            'tournament_id' => $tournament->id,
        ])->all();

        return $this->render('index', [
            'model'            => $model,
            'tournament'       => $tournament,
            'tournament_date'  => $tournament_date,
            'tournament_dates' => $tournament_dates
        ]);
    }

    /**
     * Displays tournament dates for any tournament.
     * @return string
     */
    public function actionCheckDates($id)
    {
        $tournament = Tournament::findOne($id);
        $tournament_dates = TournamentDate::find()->with('fixtures')
            ->where(['tournament_id' => $tournament->id])->all();

        return $this->render('check_dates', [
            'tournament'       => $tournament,
            'tournament_dates' => $tournament_dates
        ]);
    }

    /**
     * Handles creation of bets.
     */
    public function actionMakeBet()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'You need to be logged in to participate.'));
            return $this->redirect(['login']);
        }

        $tournament      = Tournament::find()->where(['is_active' => 1])->one();
        $tournament_date = TournamentDate::find()->with('fixtures')->where([
            'is_active'     => 1,
            'tournament_id' => $tournament->id
        ])->one();
        $bets = [];

        foreach ($tournament_date->fixtures as $fixture) {
            $fixture->datesToReadFormat();
            $bets[] = new BetForm();
        }

        if (Model::loadMultiple($bets, Yii::$app->request->post()) && Model::validateMultiple($bets)) {
            $count = 0;
            foreach ($bets as $bet) { if ($bet->register()) $count++; }
            Yii::$app->session->setFlash('success', Yii::t('app', '{count} Bets saved.', ['count' => $count]));
            return $this->redirect(['index']);
        }

        return $this->render('make_bet', [
            'tournament'      => $tournament,
            'tournament_date' => $tournament_date,
            'bets'            => $bets
        ]);
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
                ->setSubject(Yii::t('email', 'Tumibets: Account registered'))
                ->setHtmlBody('<h2>TUMIBETS</h2>
                    <p>'. Yii::t('email', 'Your new account has been registered!') .'</p>
                    <p>'. Html::a(Yii::t('email', 'Validate your account here.'),
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
