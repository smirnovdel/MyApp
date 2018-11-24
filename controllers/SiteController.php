<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
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
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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

    public function actionView($id)
    {
        $model = \app\models\SProducts::findOne(['article' => $id]);

        return $model;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $redis = new \Redis();

        $redis->connect(
        'redis',
        6379
        );

        $redis->auth("eustatos");
        $redis->bitCount("user:name");

        $redis->setBit("mykey",0,1); $redis->setBit("mykey2",0,1);
        $redis->setBit("mykey",1,0); $redis->setBit("mykey2",1,0);
        $redis->setBit("mykey",2,1); $redis->setBit("mykey2",2,1);
        $redis->setBit("mykey",3,1); $redis->setBit("mykey2",3,0);
        $redis->setBit("mykey",4,1); $redis->setBit("mykey2",4,0);
        $redis->setBit("mykey",5,1); $redis->setBit("mykey2",5,1);





        $redis->bitOp("AND", "mk", "mykey", "mykey2");
        $count = $redis->bitCount("mk");
        for ($i = 0; $i<$count; $i++) {
            $f[$i] = $redis->getBit("mk", $i);
            if ($i!=$count && $f[$i] == 0) {
                $count++;
            }
        }

        return "'" . implode("', '", $f) ."'";
        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
}
