<?php

namespace frontend\controllers;

use frontend\models\crawlerList\CrawlerListSearch;
use frontend\models\crawlers\CrawlerSites;
use yii\filters\VerbFilter;
use yii\web\Controller;


class CategoriesController extends Controller
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

    public function actionUpdateAll()
    {
        (new CrawlerSites())->UpdateCategoriesOfSites();
    }

}
