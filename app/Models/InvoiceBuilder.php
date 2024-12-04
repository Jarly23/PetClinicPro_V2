<?php

namespace App\Models;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

class InvoiceBuilder
{
    public static function buildInvoice()
    {
        // Cliente
        $client = (new Client())
            ->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA X');

        // Dirección del emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('-')
            ->setDireccion('Av. Villa Nueva 221')
            ->setCodLocal('0000');

        // Emisor
        $company = (new Company())
            ->setRuc('20123456789')
            ->setRazonSocial('GREEN SAC')
            ->setNombreComercial('GREEN')
            ->setAddress($address);

        // Factura
        $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('1')
            ->setFechaEmision(new \DateTime())
            ->setFormaPago(new FormaPagoContado())
            ->setTipoMoneda('PEN')
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas(100.00)
            ->setMtoIGV(18.00)
            ->setTotalImpuestos(18.00)
            ->setValorVenta(100.00)
            ->setSubTotal(118.00)
            ->setMtoImpVenta(118.00);

        $item = (new SaleDetail())
            ->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setMtoValorUnitario(50.00)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00)
            ->setIgv(18.00)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18.00)
            ->setMtoValorVenta(100.00)
            ->setMtoPrecioUnitario(59.00);

        $legend = (new Legend())
            ->setCode('1000')
            ->setValue('SON CIEN CON 00/100 SOLES');

        $invoice->setDetails([$item])
                ->setLegends([$legend]);

        return $invoice;
    }
}