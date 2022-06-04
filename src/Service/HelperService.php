<?php

namespace App\Service;

class HelperService
{
    public function getImgOption($prevGameId, $gameId, $nbTestGameId):String
    {
        if($prevGameId == $gameId) {
            $nbTestGameId++;
        }
        else {
            $nbTestGameId = 0;
        }
        switch ($nbTestGameId) {
            case 1:
                $idOpt="_f2";
                break;
            case 2:
                $idOpt="_f3";
                break;
            default :
                $idOpt="";
        }

        return $idOpt;
    }
}