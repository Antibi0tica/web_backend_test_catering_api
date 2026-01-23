<?php

namespace App\Controllers;

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;

    class MenuController extends BaseController {

       

        public function getMenu() {
            (new Status\Ok([
                'menu' => [
                    'pizza' => '$10',
                    'pasta' => '$8',
                    'salade' => '$6'
                ]
            ]))->send();
        }
    }