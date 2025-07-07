<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\HttpException;


class WebserviceController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id === 'get-data') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionTest()
    {
        echo "Hello";
        exit;
    }
    public function actionGetData()
    {
        // print_r( Yii::$app->request->bodyParams);
        // exit;
        $requestdata = json_decode(Yii::$app->request->getRawBody(), true);
        // Create an instance of the Yii2 HTTP Client
        $client = new Client();

        $url = 'https://api.openai.com/v1/chat/completions';  

        $apiKey = '1a5f2aec6cb44b9b9d453953240711';  

        $queryParams = [
            'key' => $apiKey, 
            'q' =>$requestdata['city'], 
            'aqi' => 'no'    
        ];

        $response = $client->get($url, $queryParams)
            ->send();

        if ($response->isOk) {
            $data = $response->data;  

            $city = $data['location']['name'];
            $temperature = $data['current']['temp_c']; 
            $condition = $data['current']['condition']['text'];  

            // Return the data as a JSON response
            return $this->asJson([
                'city' => $city,
                'temperature' => $temperature,
                'condition' => $condition,
            ]);
        } else {
            // Handle the error if the response is not OK
            throw new HttpException($response->statusCode, 'Error occurred while fetching weather data');
        }
    
    }
}
