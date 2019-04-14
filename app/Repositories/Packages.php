<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Modules\Api\Models\PaymentPackageModel;

class Packages {

    public function all() {
        return PaymentPackageModel::all();
    }

}
