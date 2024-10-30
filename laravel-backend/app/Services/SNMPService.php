<?php 

namespace App\Services; 

use Illuminate\Support\Facades\Log;
use Exception; 
use SNMP; 

class SNMPService
{
    public function getDeviceInfo($ipAddress, $community, $version = 2)
    {
        try {
            $session = new SNMP($version, $ipAddress, $community);
            
            return [
                'sysDescr' => $session->get('1.3.6.1.2.1.1.1.0'),
                'sysUpTime' => $session->get('1.3.6.1.2.1.1.3.0'),
                'sysName' => $session->get('1.3.6.1.2.1.1.5.0'),
                'ifNumber' => $session->get('1.3.6.1.2.1.2.1.0')
            ];
        } catch (Exception $e) {
            Log::error("SNMP Error: " . $e->getMessage());
            return null;
        }
    }

    public function getInterfaceMetrics($ipAddress, $community)
    {
        try {
            $session = new SNMP(2, $ipAddress, $community);
            $interfaces = [];
            
            $ifTable = $session->walk('1.3.6.1.2.1.2.2.1');
            foreach ($ifTable as $oid => $value) {
                // parse interface data
                $interfaces[] = [
                    'index' => $this->parseOID($oid),
                    'value' => $value
                ];
            }
            
            return $interfaces;
        } catch (Exception $e) {
            Log::error("SNMP Interface Error: " . $e->getMessage());
            return [];
        }
    }

    
    protected function parseOID($oid)
    {
    
        return explode('.', $oid)[count(explode('.', $oid)) - 1]; // Example logic
    }
}
