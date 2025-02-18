<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use MovieRecommendation\Enum\MovieRecommendationType;

final class MovieControllerTest extends WebTestCase
{
    public function testValidRecommendationTypes(): void
    {
        $client = $this->createClient();

        foreach (MovieRecommendationType::cases() as $type) {
            $client->request('GET', '/api/movies/recommendations/' . $type->value);
            $this->assertResponseIsSuccessful();
            $this->assertJson($client->getResponse()->getContent());

            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertArrayHasKey('recommendations', $data);
        }
    }

    public function testInvalidRecommendationType(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/api/movies/recommendations/invalid_type');

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $data);
    }
}
