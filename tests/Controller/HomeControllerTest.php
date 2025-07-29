<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional test for the HomeController.
 */
final class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // Create a client to browse the application
        $client = static::createClient();

        // Request the homepage (URL: '/')
        $client->request('GET', '/');

        // Assert that the response is successful (status code 200)
        self::assertResponseIsSuccessful();

        // Optionally check if specific content appears on the page
        self::assertSelectorTextContains('h1', 'Contact'); // Exemple de vérification d’un titre
    }
}
