<?php

namespace app\controllers;

use app\models\Notify;
use app\models\Reserve;
use Yii;
use app\models\Book;
use app\models\search\BookSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Операции с книгами
 *
 * Class BooksController
 * @package app\controllers
 */
class BooksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Книга не найдена.');
    }

    /**
     * Резервирование книги
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionReserve($id)
    {
        $book = $this->findModel($id);
        if($book->canReserve()) {
            if($book->reservation) {
                $reserve = $book->reservation;
            }
            else {
                $reserve = new Reserve();
                $reserve->book_id = $book->id;
                $reserve->user_id = Yii::$app->user->identity->getId();
            }
            $reserve->status = Reserve::RESERVED;

            if($reserve->save()) {
                Yii::$app->session->setFlash('success', 'Книга зарезервирована.');
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка резервирования.');
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Эта книга уже зарезервирована вами, либо у вас на руках.');
        }

        return $this->redirect(['view', 'id' => $book->id]);
    }

    /**
     * Отмена резервирования
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionReserveCancel($id)
    {
        $book = $this->findModel($id);
        if($book->isReserved()) {
            $reserve = $book->reservation;
            $reserve->status = Reserve::SUBMITTED;
            if($reserve->save()) {
                Yii::$app->session->setFlash('success', 'Резервирование отменено.');
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка отмены резервирования.');
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Вы не резервировали эту книгу.');
        }

        return $this->redirect(['view', 'id' => $book->id]);
    }

    /**
     * Взять книгу и зарегистрировать за пользователем
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTakeBook($id)
    {
        $book = $this->findModel($id);
        if($book->isAvailable()) {
            if($book->reservation) {
                $reserve = $book->reservation;
            }
            else {
                $reserve = new Reserve();
                $reserve->book_id = $book->id;
                $reserve->user_id = Yii::$app->user->identity->getId();
            }
            $reserve->status = Reserve::UNAVAILABLE;
            if($reserve->save()) {
                Yii::$app->session->setFlash('success', 'Книга зарегестрирована за вами.');
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка регистрации книги.');
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Книгу забрали, либо ваша очередь на эту книгу еще не подошла.');
        }

        return $this->redirect(['view', 'id' => $book->id]);
    }

    /**
     * Сдать книгу зарегистрированную за пользователем
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubmitBook($id)
    {
        $book = $this->findModel($id);
        if($book->canSubmit()) {
            $reserve = $book->reservation;
            $reserve->status = Reserve::SUBMITTED;
            if($reserve->save()) {
                Yii::$app->session->setFlash('success', 'Вы сдали книгу.');
                Notify::nextReservedUser($id);
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка при сдаче книги.');
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Вы не можете сдать эту книгу, так как она не числится за вами.');
        }

        return $this->redirect(['view', 'id' => $book->id]);
    }
}
