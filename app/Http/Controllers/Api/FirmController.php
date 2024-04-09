<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirmController extends Controller
{
    public function getEnterpriseList(Request $request)
    {
        $checkTypeId = $request->input('typeId');

        $data = Firm::where('check_type', $checkTypeId)
            ->select('custom_number as number', 'id', 'name as enterpriseName', 'address')
        ->get();

        return response()->json($data);
    }

    public function getCheckStatusList()
    {
        return response()->json($this->getCheckStatus());
    }

    private function getCheckStatus()
    {
        $statusList = Firm::$formatStatusMaps;
        $data       = [];
        foreach ($statusList as $key => $status) {
            $data[] = [
                'id'      => $key,
                'orderBy' => 0,
                'uuid'    => '',
                'name'    => $status,
            ];
        }
        return $data;
    }

    public function getEnterprise(Request $request)
    {
        $number = $request->input('number');
        $firm   = Firm::where('custom_number', $number)
            ->select('custom_number as number', 'id', 'name as enterpriseName', 'check_type as checkTypeID', 'address', 'area_quantity as businessArea', 'status as checkStatusID', 'floor as floorNum', 'head_man as manager', 'remark as remake', 'phone as phoneFull')
            ->first();
        $firm->checkStatusName = Firm::$formatStatusMaps[$firm->checkStatusID];
        $firm->checkTypeName = Firm::$formatCheckTypeMaps[$firm->checkTypeID];

        return response()->json([
            'enterprise' => $firm,
            'ctList' => CheckStandardController::getCheckType(),
            'csList'     => $this->getCheckStatus(),
        ]);
    }
}
