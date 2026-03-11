<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Service\OrderSoapService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SoapController
 * @package Controller
 */
class SoapController extends BaseController
{
    /**
     * @param OrderSoapService $service
     * @return Response
     */
    #[Route('/soap', name: 'soap_server', methods: ['POST'])]
    public function handle(OrderSoapService $service): Response
    {
        $server = new \SoapServer(null, [
            'uri' => 'http://localhost/soap'
        ]);
        $server->setObject($service);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');

        $level = ob_get_level();
        ob_start();
        try {
            $server->handle();
            $content = ob_get_clean();
        } finally {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
        }

        $response->setContent($content ?? '');

        return $response;
    }
}
