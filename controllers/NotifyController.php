<?php

namespace app\controllers;

use app\models\Notify;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BookController implements the CRUD actions for Notify model.
 */
class NotifyController extends Controller
{
    /**
     * Displays a single Notify model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $notify = $this->findModel($id);
        $notify->view();

        return $this->render('view', [
            'model' => $notify,
        ]);
    }

    /**
     * Finds the Notify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notify::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Сообщение не найдено.');
    }
}
