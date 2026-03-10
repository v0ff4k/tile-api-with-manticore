<?php

namespace Controller;

use Service\OrderSoapService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SoapController
 * @package Controller
 */
class SoapController extends BaseController
{
    /**
     * @param \Service\OrderSoapService $service
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/soap', name: 'soap_server')]
    public function handle(OrderSoapService $service): Response
    {
        $server = new \SoapServer(null, [
            'uri' => 'http://localhost/soap'
        ]);
        $server->setObject($service);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}
