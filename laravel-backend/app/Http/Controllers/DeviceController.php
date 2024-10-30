<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Services\SNMPService;

class DeviceController extends Controller
{
    //
    protected $snmpService;

    public function __construct(snmpService $snmpService){
        $this->snmpService = $snmpService;
    }

    public function index(){
        $devices = Device::with(['metrics'=>function($query){
            $query->latest()->take(100);
        }])->get();

        return response()->json($devices);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'hostname' => 'required|string',
            'ip_address' => 'required|ip',
            'type' => 'required|string',
            'snmp_community' => 'required|string',
            'snmp_version' => 'required|integer|in:1,2,3'

        ])
}
