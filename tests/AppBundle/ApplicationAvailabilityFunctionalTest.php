<?php


namespace Tests\AppBundle;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider urlProviderAnonymous
     */
    public function testUrlForAnonymous($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlProviderAdmin
     */
    public function testUrlForAdmin($url)
    {
        $this->logIn();
        $this->client->request('GET', $url);

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    // Authenticate an user with the role admin.
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function urlProviderAnonymous()
    {
        return array(
            array('/'),
            array('/faq'),
            array('/programmes'),
            array('/programmes/contact'),
            array('/login'),
            array('/newsletter/'),
        );
    }

    public function urlProviderAdmin()
    {
        return array(
            array('/observation'),
            array('/observation/carte'),
            array('/observation/espacepro'),
            array('/faq/admin'),
            array('/programmes/admin'),
            array('/programmes/admin/newblog'),
        );
    }
}