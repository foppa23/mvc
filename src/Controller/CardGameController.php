<?php

namespace App\Controller;

// use App\Card\Card;
// use App\Card\CardHand;
// use App\Card\CardGraphic;
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
        Request $request,
        SessionInterface $session
    ): Response
    {
        $data = [
            'session' => $session -> all()
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionDestroy(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $session -> clear();

        $this->addFlash(
            'notice',
            'Sessionen rensades!'
        );

        return $this->redirectToRoute('session');
    }



}





/*


    #[Route("/game/pig", name: "pig_start")]
    public function home(): Response
    {
        return $this->render('pig/home.html.twig');
    }

    #[Route("/game/pig/test/roll", name: "test_roll_dice")]
    public function testRollDice(): Response
    {
        $die = new Dice();                          // Skapa ett tärningsobjekt

        $data = [
            "dice" => $die->roll(),                 // Rulla tärningen
            "diceString" => $die->getAsString(),    // Hämta värdet på tärningen som en sträng
        ];

        return $this->render('pig/test/roll.html.twig', $data); // Skicka in i templatefilen
    }

    #[Route("/game/pig/test/roll/{num<\d+>}", name: "test_roll_num_dices")]     // <\d+> enbart siffror
    public function testRollDices(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $diceRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            //$die = new Dice();
            $die = new DiceGraphic();
            $die->roll();
            $diceRoll[] = $die->getAsString();      // Spara tärningsslagen i en array
        }

        $data = [
            "num_dices" => count($diceRoll),
            "diceRoll" => $diceRoll,
        ];

        return $this->render('pig/test/roll_many.html.twig', $data);
    }

    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]       // <\d+> enbart siffror
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new DiceGraphic());      // Inject object into class
            } else {
                $hand->add(new Dice());
            }
        }

        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/test/dicehand.html.twig', $data);
    }

    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }


    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,                   // Injecta variablerna request och session. Ramverket sköter resten.
        SessionInterface $session
    ): Response {
        $numDice = $request->request->get('num_dices');     // Hämta antal valda tärningar från request/formuläret

        $hand = new DiceHand();                     // Skapa tärningshanden
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();                              // Rulla alla tärningar

        $session->set("pig_dicehand", $hand);       // Spara i sessionen
        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);

        return $this->redirectToRoute('pig_play');
    }


    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {
        $dicehand = $session->get("pig_dicehand");          // Hämta tärningshanden från sessionen

        $data = [
            "pigDices" => $session->get("pig_dices"),       // Hämta från sessionen
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString()          // Hämta tärningshanden som en sträng
        ];

        return $this->render('pig/play.html.twig', $data);
    }



    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("pig_dicehand");          // Hämta tärningshanden från sessionen
        $hand->roll();

        $roundTotal = $session->get("pig_round");       // Summa för denna rundan
        $round = 0;                                     // Summan för detta kast
        $values = $hand->getValues();                   // Hämta tärningarnas värde
        foreach ($values as $value) {
            if ($value === 1) {                         // Om slår 1:a
                $round = 0;                             // Nollställ detta kast
                $roundTotal = 0;                        // Nollställ denna rundan

                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );

                break;
            }
            $round += $value;
        }

        $session->set("pig_round", $roundTotal + $round);

        return $this->redirectToRoute('pig_play');
    }



    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('pig_play');
    }
}


 */