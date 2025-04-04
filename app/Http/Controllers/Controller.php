<?php

namespace App\Http\Controllers;

use App\Services\AniListService;

abstract class Controller
{
    //
    protected $aniListService;

     public function __construct(AniListService $aniListService)
     {
         $this->aniListService = $aniListService;
     }
}