<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Deck;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api')]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }

    #[Route('/api/quote', name: 'api_quote')]
    public function jsonQuote(): JsonResponse
    {
        date_default_timezone_set('Europe/Stockholm');

        $quotes = [
            "Hemligheten till en bra dygnsrytm är att aldrig sova.",
            "Man ska aldrig generalisera.",
            "When people tell me you are going to regret that in the morning. I sleep until late afternoon because I am a problem solver."
        ];

        $time = date('Y-m-d H:i:s');

        $index = array_rand($quotes);
        $randomQuote = $quotes[$index];

        $data = [
            'quote' => $randomQuote,
            'date' => $time
        ];

        $response = new JSONResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route('/api/deck', name: 'api_deck', methods: ['GET'])]
    public function getDeck(): JsonResponse
    {
        $deck = new Deck();

        $deckStrings = [];
        foreach ($deck->getDeck() as $card) {
            $deckStrings[] = (string)$card;
        }

        $data = [
            'deck' => $deckStrings
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route('/api/deck/shuffle', name: 'api_shuffle_deck', methods: ['POST'])]
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = new Deck();
        $deck->shuffleDeck();

        $session->set('deck', $deck->getDeck());

        $deckStrings = [];
        foreach ($deck->getDeck() as $card) {
            $deckStrings[] = (string)$card;
        }

        $data = [
            'deck' => $deckStrings
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route('/api/deck/draw', name: 'api_draw_one', methods: ['POST'])]
    public function drawOne(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', []);
        $drawnCard = array_shift($deck);

        $session->set('deck', $deck);

        $cards = [];
        if ($drawnCard !== null) {
            $cards[] = (string) $drawnCard;
        }

        $data = [
            'drawn_card' => $cards,
            'remaining_cards' => count($deck)
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route('/api/deck/draw/{number<\d+>}', name: 'api_draw_cards', methods: ['POST'])]
    public function drawNumber(int $number, SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', []);
        $drawnCards = [];

        for ($i = 0; $i < $number; $i++) {
            $card = array_shift($deck);
            if ($card !== null) {
                $drawnCards[] = (string) $card;
            }
        }

        $session->set('deck', $deck);

        $data = [
            'drawn_cards' => $drawnCards,
            'remaining_cards' => count($deck)
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

}
