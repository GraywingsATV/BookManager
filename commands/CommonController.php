<?php

namespace app\commands;

use app\models\Book;
use yii\console\Controller;
use yii\console\ExitCode;
use Faker\Factory;


class CommonController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param integer $number the message to be echoed.
     * @return int Exit code
     */
    public function actionCreateBooks($number)
    {
        $faker = Factory::create();
        for($count = 0; $count < $number; $count++) {
            $book = new Book();
            $book->title = $faker->text(rand(10, 25));
            $book->save();
        }

        return ExitCode::OK;
    }
}
