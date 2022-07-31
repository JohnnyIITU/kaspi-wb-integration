<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @param $company
     * @return void
     * @throws BadRequestHttpException
     */
    public function upload(Request $request, $company) {
//        $this->checkCompanyExist($company);
        Log::debug($request->all());
        return [
            'success' => true
        ];
        if ($request->file('xml') === null) {
            throw new BadRequestHttpException();
        }
    }

    /**
     * @param $company
     * @return void
     * @throws NotFoundHttpException
     */
    private function checkCompanyExist($company) : void
    {
        $item = Company::query()
            ->where('company_id', $company)
            ->first();
        if ($item === null) {
            throw new NotFoundHttpException();
        }
    }
}
