<?php

namespace App\Controller;

use App\Card\Deck;
// use App\Card\CardGraphic;
// use App\Card\CardHand;
// use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function sessionView(
        SessionInterface $session
    ): Response {
        $data = [
            'session' => $session -> all()
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionDestroy(
        SessionInterface $session
    ): Response {
        $session -> clear();

        $this->addFlash(
            'notice',
            'Sessionen rensades!'
        );

        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card_home")]
    public function cardHome(
        SessionInterface $session
    ): Response {
        // Initiate deck if no deck already in session
        if (!$session->has('deck')) {
            $deck = new Deck();
            $session->set('deck', $deck->getDeck());
        }

        // Get deck from session
        $deck = $session->get('deck');

        // Display deck on page
        return $this->render('card/card.html.twig', [
            'deck' => $deck
        ]);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(SessionInterface $session): Response
    {
        // Initiate deck if no deck already in session
        if (!$session->has('deck')) {
            $deck = new Deck();
            $session->set('deck', $deck->getDeck());
        }

        // Get deck from session
        $deck = $session->get('deck');

        // Display deck on page
        return $this->render('card/deck.html.twig', [
            'deck' => $deck
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {
        // Get deck from session
        $deck = $session->get('deck');

        // Shuffle cards in new deck
        $newDeck = new Deck();
        $newDeck->shuffleDeck();

        // Save shuffled deck in session
        $session->set('deck', $newDeck->getDeck());

        // Redirect to Card home page
        return $this->redirectToRoute('card_home');
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(
        SessionInterface $session
    ): Response {
        // Get deck from session
        $deck = $session->get('deck');

        $drawnCard = array_shift($deck);

        // Save updated deck in session
        $session->set('deck', $deck);

        // Display drawn card and number of remaining cards
        return $this->render('card/draw.html.twig', [
            'drawnCard' => $drawnCard,
            'remainingCards' => count($deck)
        ]);
    }

    #[Route("/card/deck/draw-multi", name: "card_draw_multi_form")]
    public function drawMultiForm(
        Request $request,
        SessionInterface $session
    ): Response {
        // Get number of cards
        $num = $request->query->getInt('num');

        $deck = $session->get('deck');
        $cardsDrawn = [];

        if ($num > 0) {
            for ($i = 0; $i < $num; $i++) {
                $card = array_shift($deck);
                if ($card !== null) {
                    $cardsDrawn[] = $card;
                }
            }

            $session->set('deck', $deck);
        }

        return $this->render('card/draw-multi-form.html.twig', [
            'cardsDrawn' => $cardsDrawn,
            'remainingCards' => count($deck),
        ]);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_num")]
    public function drawNum(
        int $num,
        SessionInterface $session
    ): Response {
        // Get deck from session
        $deck = $session->get('deck');

        // Draw specific number of cards
        $cardsDrawn = [];
        for ($i = 0; $i < $num; $i++) {
            $card = array_shift($deck);
            if ($card !== null) {
                $cardsDrawn[] = $card;
            }
        }

        // Update deck in session
        $session->set('deck', $deck);

        // Display drawn cards and number of remaining cards
        return $this->render('card/draw-num.html.twig', [
            'cardsDrawn' => $cardsDrawn,
            'remainingCards' => count($deck)
        ]);
    }
}
