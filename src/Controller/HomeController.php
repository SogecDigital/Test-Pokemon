<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        $prevGameId = 0;
        $nbTestGameId = 0;
        $pokemons = $pokemonRepository->findAll();
        foreach($pokemons as $pokemon){
            if($pokemon->getGameId() < 10) $id="00".$pokemon->getGameId();
            elseif($pokemon->getGameId() < 100 && $pokemon->getGameId() >= 10) $id="0".$pokemon->getGameId();
            else $id=$pokemon->getGameId();

            if(!str_ends_with($pokemon->getName(), ' Size')) {
                if ($prevGameId == $pokemon->getGameId()) {
                    $nbTestGameId++;
                } else {
                    $nbTestGameId = 0;
                }
                $idOpt = match ($nbTestGameId) {
                    1 => "_f2",
                    2 => "_f3",
                    default => "",
                };
                $id .= $idOpt;
            }

            echo '<img src="https://assets.pokemon.com/assets/cms2/img/pokedex/full/'.$id.'.png">';
            $prevGameId = $pokemon->getGameId();
            if ($nbTestGameId == 2) $nbTestGameId = 0;
        }

        return new Response;
    }
}
