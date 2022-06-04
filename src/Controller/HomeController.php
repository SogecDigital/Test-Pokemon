<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use App\Repository\PokemonTypeRepository;
use App\Service\HelperService;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PokemonRepository $pokemonRepository, HelperService $helperService, PokemonTypeRepository $pokemonTypeRepository): Response
    {
        $prevGameId = 0;
        $nbTestGameId = 0;
        $pokemons = $pokemonRepository->findAll();
        foreach($pokemons as $pokemon){
            if($pokemon->getGameId() < 10) $id="00".$pokemon->getGameId();
            elseif($pokemon->getGameId() < 100 && $pokemon->getGameId() >= 10) $id="0".$pokemon->getGameId();
            else $id=$pokemon->getGameId();

            if(!str_ends_with($pokemon->getName(), ' Size')) $id .= $helperService->getImgOption($prevGameId, $pokemon->getGameId(), $nbTestGameId);

            echo '<img src="https://assets.pokemon.com/assets/cms2/img/pokedex/full/'.$id.'.png">';
            $prevGameId = $pokemon->getGameId();
            if ($nbTestGameId == 2) $nbTestGameId = 0;
        }

        return new Response;
    }
}
