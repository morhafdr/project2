<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Traits\PdfTrait;
use Illuminate\Http\Request;


class PdfController extends Controller
{
    use PdfTrait;
    public function downloadMonthlyReport()
    {
        return $this->generateMonthlyReport();
    }


}
