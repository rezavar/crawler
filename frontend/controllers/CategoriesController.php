<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\CategoryTmpTree;
use frontend\models\categories\CategoryOurName;
use frontend\models\crawlerList\CrawlerListSearch;
use frontend\models\crawlers\CrawlerSites;
use yii\filters\VerbFilter;
use yii\helpers\Url;
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

    public function actionUpdate($CrawlerListId)
    {
//        (new CrawlerSites())->UpdateCategoriesOfSites($CrawlerListId);
//        (new Category())->FillFromTmpCategory($CrawlerListId);
        $this->redirect(['update-category','CrawlerListId'=>$CrawlerListId]);
    }

    public function actionUpdateCategory($CrawlerListId,$Status=null)
    {
        $displayValue=1;
        if(\Yii::$app->request->isPost){
            $form = new CategoryOurName();
            if($form->load(\Yii::$app->request->post()) && $form->validate())
                $form->saveOurName();
            if($form->CategoryId)
                $displayValue= $form->CategoryId;
        }

        $query = Category::find()
            ->andWhere(['CrawlerListIdRef'=>$CrawlerListId])
            ->addOrderBy('root, lft');

        if($Status!==null){
            $query= $query->andWhere(['Status'=>$Status]);
        }

        return $this->render('update-category', [
            'newTreeQuery' => $query,
            'displayValue'=>$displayValue,
            'CrawlerListId'=>$CrawlerListId,
            'Status'=>$Status
        ]);

    }


}
