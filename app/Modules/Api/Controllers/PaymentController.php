<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\PaymentsModel;
use App\Helpers\Session as AppSession;
use App\Modules\Api\Models\UserModel;

class PaymentController extends Controller {

    /**
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return Response payment system settings
     */
    public function getTransactionDetail($id) {
        $userData = AppSession::getLoginData();
        if (!$userData || ($userData->role != UserModel::ROLE_ADMIN && $userData->role != UserModel::ROLE_SUPERADMIN)) {

            return Response()->json(array('success' => false, 'error' => 'You do not have permission.'));
        }
        $model = PaymentsModel::find($id);
        return Response()->json(array('success' => true, 'data' => $model));
    }

    public function getMyTransactionDetail($id) {
        $userData = AppSession::getLoginData();

        $model = PaymentsModel::find($id);
        if ($model->memberId !== $userData->id) {
            return Response()->json(array('success' => false, 'error' => 'You do not have permission.'));
        }
        return Response()->json(array('success' => true, 'data' => $model));
    }

}
