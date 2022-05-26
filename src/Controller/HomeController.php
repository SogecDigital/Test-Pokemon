<?php

namespace App\Controller;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): JsonResponse
    {
        $csvPath="../pokemon.csv";
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $datas = $serializer->decode(file_get_contents($csvPath), 'csv', [CsvEncoder::DELIMITER_KEY => ',']);
        $types = array();
        foreach ($datas as $data)
        {
            if(!in_array($data['Type 1'], $types) && $data['Type 1'] != NULL){
                array_push($types, $data['Type 1']);
            }     
        }
        dd($datas);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
}
