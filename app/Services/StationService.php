<?php

namespace App\Services;

use App\Station;
use Illuminate\Http\Request;

class StationService
{
    public function getByRadius(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        if($latitude == null || $longitude == null || $radius == null){
            return response()->json([
                'error' => 'Resource not found'
            ], 404);
        }
        $stations = Station::all();

        foreach($stations as $station){
            $distance = $this->calculateDistance($latitude, $longitude, $station->latitude, $station->longitude);
            $distance = intval($distance);

            if($distance < $radius){
                $tmp = ['station' => $station, 'distance' => $distance];
                $result[]= $tmp;
            }
        }

        $result = $this->orderStations($result);

        return response()->json($result);
    }

    public function calculateDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $distance =( 6371 * acos((cos(deg2rad($latitudeFrom)) ) * (cos(deg2rad($latitudeTo))) * (cos(deg2rad($longitudeFrom) - deg2rad($longitudeTo)) )+ ((sin(deg2rad($latitudeTo))) * (sin(deg2rad($latitudeFrom))))) );

        return $distance;
    }

    public function orderStations($stations)
    {
        usort($stations, array($this,'sortByDistance'));

        return $stations;
    }

    private static function sortByDistance($x, $y) {
        return $x['distance'] - $y['distance'];
    }
}