<?php

namespace frontend\controllers;

use common\models\CrawlerList;
use frontend\models\CrawlerListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrawlerListController implements the CRUD actions for CrawlerList model.
 */
class CrawlerListController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all CrawlerList models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CrawlerListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CrawlerList model.
     * @param int $IdCrawlerList شناسه خزنده
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdCrawlerList)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdCrawlerList),
        ]);
    }

    /**
     * Creates a new CrawlerList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CrawlerList();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'IdCrawlerList' => $model->IdCrawlerList]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CrawlerList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdCrawlerList شناسه خزنده
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdCrawlerList)
    {
        $model = $this->findModel($IdCrawlerList);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IdCrawlerList' => $model->IdCrawlerList]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CrawlerList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdCrawlerList شناسه خزنده
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdCrawlerList)
    {
        $this->findModel($IdCrawlerList)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CrawlerList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdCrawlerList شناسه خزنده
     * @return CrawlerList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdCrawlerList)
    {
        if (($model = CrawlerList::findOne(['IdCrawlerList' => $IdCrawlerList])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
