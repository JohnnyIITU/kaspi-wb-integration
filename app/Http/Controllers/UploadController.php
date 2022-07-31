<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @param $company
     * @throws BadRequestHttpException
     */
    public function upload(Request $request, $company) {
        $this->checkCompanyExist($company);
        if ($request->get('xml') === null) {
            throw new BadRequestHttpException();
        }
        $xml = $request->get('xml');
        $fileName = "kaspi/files/".strtolower($company) . '.xml';
        if (Storage::disk('local')->exists($fileName)) {
            Storage::delete($fileName);
        }
        Storage::put($fileName, $xml);
        return response()->json([
            'success' => true,
        ]);
    }

    public function price($company) {
        $this->checkCompanyExist($company);
        $fileName = "kaspi/files/".strtolower($company) . '.xml';
        if (Storage::disk('local')->exists($fileName)) {
            $file = Storage::disk('local')->get($fileName);
            return response()->file($file);
        }
        return [
            'success' => false
        ];
    }

    /**
     * @param $company
     * @return void
     * @throws NotFoundHttpException
     */
    private function checkCompanyExist($company) : void
    {
        $item = Company::query()
            ->where('company', $company)
            ->first();
        if ($item === null) {
            throw new NotFoundHttpException();
        }
    }
}
