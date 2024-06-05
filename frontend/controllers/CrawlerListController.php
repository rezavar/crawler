<?php

namespace frontend\controllers;

use frontend\models\crawlerList\CrawlerList;
use frontend\models\crawlerList\CrawlerListSearch;
use frontend\models\crawlers\sites\Takhfifaneh;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class CrawlerListController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        $searchModel = new CrawlerListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTest()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $t = new Takhfifaneh();
        $list =$t->ParsCategory();
        $t->saveCategory($list);
        return $list;

    }


    public function actionView($CrawlerListId)
    {
        return $this->render('view', [
            'model' => $this->findModel($CrawlerListId),
        ]);
    }

    protected function findModel($CrawlerListId)
    {
        if (($model = CrawlerList::findOne(['CrawlerListId' => $CrawlerListId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $model = new CrawlerList();
        $model->setScenarioInsert();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
                return $this->redirect(['view', 'CrawlerListId' => $model->CrawlerListId]);

            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($CrawlerListId)
    {
        $model = $this->findModel($CrawlerListId);
        $model->setScenarioUpdate();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CrawlerListId' => $model->CrawlerListId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($CrawlerListId)
    {
        $this->findModel($CrawlerListId)->delete();

        return $this->redirect(['index']);
    }
}
