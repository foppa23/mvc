<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $images = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'];

        $index = array_rand($images);
        $imageName = $images[$index];

        $data = [
            'image' => $imageName
        ];

        return $this->render('lucky.html.twig', $data);
    }
}
// #[Route("/api", name: "api")]
// public function api(): Response
// {
//     return $this->render('api.html.twig');
// }

// #[Route("/api/quote")]
// public function jsonQuote(): Response
// {
//     date_default_timezone_set('Europe/Stockholm');

//     $quotes = [
//         "Hemligheten till en bra dygnsrytm är att aldrig sova.",
//         "Man ska aldrig generalisera.",
//         "When people tell me you are going to regret that in the morning. I sleep until late afternoon because I am a problem solver."
//     ];

//     $time = date('Y-m-d H:i:s');

//     $index = array_rand($quotes);
//     $randomQuote = $quotes[$index];

//     $data = [
//         'quote' => $randomQuote,
//         'date' => $time
//     ];

//     $response = new JSONResponse($data);
//     $response->setEncodingOptions(
//         $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
//     );

//     return $response;
// }
