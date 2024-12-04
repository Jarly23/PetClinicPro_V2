<?php

namespace App\Http\Controllers;

use App\Services\GreenterService;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceBuilder;

class InvoiceController extends Controller
{
    public function sendInvoice(GreenterService $greenter)
    {
        $see = $greenter->getSee();
        $invoice = InvoiceBuilder::buildInvoice();

        $result = $see->send($invoice);

        // Guardar XML firmado
        file_put_contents(storage_path('app/'.$invoice->getName().'.xml'), $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {
            return response()->json([
                'error_code' => $result->getError()->getCode(),
                'error_message' => $result->getError()->getMessage(),
            ], 400);
        }

        // Guardar CDR
        file_put_contents(storage_path('app/R-'.$invoice->getName().'.zip'), $result->getCdrZip());

        return response()->json(['status' => 'Invoice sent successfully']);
    }
}
