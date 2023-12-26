<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/',function (Request $request) {
    // Ваш API-ключ
    $apiKey = 'AIzaSyCTBN1VMGfDQn25s5QvNUWtUXkGazy31iQ';

    // Идентификатор вашего Google Spreadsheet
    $spreadsheetId = '10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw';

    // URL для получения данных из Google Sheets API
    $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/MA?key={$apiKey}";

    // Создаем Guzzle клиент
    $client = new Client();

    try {
        // Выполняем GET-запрос
        $response = $client->get($url);

        // Получаем JSON-данные из ответа
        $data = json_decode($response->getBody(), true);

        dd($data);

        return response()->json(['message' => 'Данные успешно прочитаны и обработаны.']);
    } catch (\Exception $e) {
        // Обработка ошибок
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
