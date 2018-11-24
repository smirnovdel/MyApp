<?php
/**
 * Created by PhpStorm.
 * User: aa.smirnov
 * Date: 22.11.2018
 * Time: 15:41
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class ExportToRedis  extends Controller
{
    public function actionDownloadFilter()
    {
        $model = new DownloadRef();


        echo 'Количество записей: ' . $model->downloadHandbk($file) . "\n";
        return ExitCode::OK;
    }


}