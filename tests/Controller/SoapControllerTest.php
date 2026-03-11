<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SoapControllerTest extends WebTestCase
{
    public function testSoapEndpointReturnsXml(): void
    {
        static::bootKernel();
        $client = static::getContainer()->get('test.client');

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:test">
  <soapenv:Body>
    <urn:createOrder>
      <orderData>
        <item>
          <key>name</key>
          <value>order</value>
        </item>
      </orderData>
    </urn:createOrder>
  </soapenv:Body>
</soapenv:Envelope>
XML;

        $client->request('POST', '/soap', server: ['CONTENT_TYPE' => 'text/xml; charset=UTF-8'], content: $xml);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('text/xml', (string) $client->getResponse()->headers->get('Content-Type'));
    }
}

