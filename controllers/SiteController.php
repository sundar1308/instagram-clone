<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Response;
use app\models\Signup;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\Notifications;
use app\models\Posts;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout= 'auth';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'=>['logout','index'],
                'rules' => [
                    // Allow access for guest users only for login and signup actions
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'], // Only login and signup accessible to guests
                        'roles' => ['?'], // ? represents guest user (not logged in)
                    ],
                    // Allow access for authenticated users for all other actions
                    [
                        'allow' => true,
                        'actions' => ['logout', 'index'], // example of actions that require auth
                        'roles' => ['@'], // @ represents authenticated (logged-in) users
                    ],
                   
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout='main';
        $post = new Posts();
        $users = User::find()->where(['<>','id',Yii::$app->user->id])->all();
        $totalPosts = Posts::find()->count();
       
        return $this->render('index',[
            'post'=>$post,
            'totalPosts' => $totalPosts,
            'suggestions'=>   $users,

        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->login()) {
                
                Yii::info('User logged in: ' . Yii::$app->user->identity->username, __METHOD__);
                return $this->redirect(['site/index']);
            } else {
    
                Yii::debug('Login failed: ' . print_r($model->errors, true), 'login');

            }
        }
    
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionSignup()
    {
        $model = new User();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            $model->password_hash =Yii::$app->security->generatePasswordHash(Yii::$app->request->post('User')['password_hash']);
            $model->save();
            Yii::$app->session->setFlash('success','User added');
            return $this->redirect(['login']);
        }
        return $this->render('signup',[
            'model'=>$model
        ]);
    }
}
