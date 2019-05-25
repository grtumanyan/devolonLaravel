<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use App\Services\StationService;

class StationController extends Controller
{

    protected $stationService;

    public function __construct(StationService $stationService)
    {
        $this->stationService = $stationService;
    }

    public function index()
    {
        return Station::all();
    }

    public function radius(Request $request)
    {
        return $this->stationService->getByRadius($request);
    }

    public function show(Station $station)
    {
        return $station;
    }

    public function store(Request $request)
    {
        $station = Station::create($request->all());

        return response()->json($station, 201);
    }

    public function update(Request $request, Station $station)
    {
        $station->update($request->all());

        return response()->json($station, 200);
    }

    public function delete(Station $station)
    {
        $station->delete();

        return response()->json(null, 204);
    }
}
