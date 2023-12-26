<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class GoogleSheetsException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Google Sheets API Exception: ' . $this->getMessage());
    }
}
