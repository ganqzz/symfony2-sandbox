<?php

namespace Hoge\BasicsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class BasicsControllerTest extends WebTestCase
{
    public function testHello()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tb/helloworld');
        $result = $crawler->filter('html:contains("Hello World")')->count();
        $expected = 0;
        $this->assertGreaterThan($expected, $result);
    }

    public function testCoolAssertions()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tb/helloworld');
        $this->assertCount(1, $crawler->filter('h1'));

        $this->assertNotEmpty(array('Andrew', 'John', 'Jane'));

        $this->assertTrue($client->getResponse()->isSuccessful());

        $notNullVar = 'Not Null';
        $this->assertNotNull($notNullVar);

        $this->assertRegExp('/from the Basics/', $client->getResponse()->getContent());

        $this->assertFalse(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testHelloContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tb/helloworld');

        $h1 = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('Hello World!', $h1);

        $p1 = $crawler->filter('p')->first();
        $p1Text = $p1->text();
        $this->assertRegExp('/from the Basics/', $p1Text);

        $ul = $p1->siblings()->eq(1);
        $l1 = $ul->children()->first()->text();
        $l2 = $ul->children()->eq(1)->text();
        $l3 = $ul->children()->last()->text();
        $this->assertEquals('Andrew', $l1);
        $this->assertEquals('John', $l2);
        $this->assertEquals('Jane', $l3);

        $p2 = $crawler->filterXpath('//p')->last()->text();
        $this->assertEquals('Goodbye World!', $p2);
    }

    public function testAddingContent()
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent('<p class="para">Added via the Crawler</p>');
        $p1 = $crawler->filter('p')->first()->text();
        $this->assertRegExp('/via the/', $p1);

        $p1Class = $crawler->filter('p')->attr('class');
        $this->assertEquals('para', $p1Class);
    }

    public function testForms()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tb/helloworld');

        $form = $crawler->selectButton('send')->form();

        $uri = $form->getUri();
        $this->assertRegExp('/localhost/', $uri);

        $method = $form->getMethod();
        $this->assertEquals('GET', $method);

        $form['name'] = 'Andrew Perkins';
        $crawler = $client->submit($form);
        $data = $form->getPhpValues();
        $expected = array('name' => 'Andrew Perkins', 'send' => 'Send');
        $this->assertEquals($expected, $data);
    }
}
