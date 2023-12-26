<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Cost;
use App\Services\GoogleSheetsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ParseBudgetTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-budget-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the budget table from Google Sheets';

    /**
     * Execute the console command.
     */
    public function handle(GoogleSheetsService $googleSheetsService)
    {


        $apiKey = Config::get('app.google_sheets_api_key');

        $spreadsheetId = '10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw';


        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}/values/MA?key={$apiKey}";

        $response = $googleSheetsService->fetchData($url);
        $data = json_decode($response->getBody(), true);


        $inputData = [];
        $categories = [];
        $currentCategoriesId = 0;
        $currentCategoriesName = '';

        foreach (array_slice($data['values'], 3) as $index => $row) {
            $rowLength = count($row);

            if ($rowLength === 1) {
                // Элемент с длиной 1 считаем категорией
                $currentCategoriesId++;
                $currentCategoriesName = $row[0];
                $categories [] = ['id' => $currentCategoriesId, 'name' => $currentCategoriesName];
            } elseif ($rowLength >= 14) {

                if ($row[0] === 'Total') {
                    continue;
                }

                if ($row[0] === 'CO-OP') {
                    break;
                }

                // Элемент с длиной боле  14 считаем продуктом и добавляем в текущую категорию
                $inputData[] = [
                    'category_id' => $currentCategoriesId,
                    'name' => $row[0],
                    'total' => $this->cleanCurrency($row[13]),
                    'january' => $this->cleanCurrency($row[1]),
                    'february' => $this->cleanCurrency($row[2]),
                    'march' => $this->cleanCurrency($row[3]),
                    'april' => $this->cleanCurrency($row[4]),
                    'may' => $this->cleanCurrency($row[5]),
                    'june' => $this->cleanCurrency($row[6]),
                    'july' => $this->cleanCurrency($row[7]),
                    'august' => $this->cleanCurrency($row[8]),
                    'september' => $this->cleanCurrency($row[9]),
                    'october' => $this->cleanCurrency($row[10]),
                    'november' => $this->cleanCurrency($row[11]),
                    'december' => $this->cleanCurrency($row[12]),
                ];

            }
        }


        Category::query()->delete();
        Category::insert($categories);

        Cost::query()->delete();
        Cost::insert($inputData);


    }

    private function cleanCurrency(?string $value): ?float
    {
        return $value ? floatval(str_replace(['$', ','], '', $value)) : null;
    }
}
