<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function createInvoice($data)
    {
        return Invoice::create($data);
    }
}
