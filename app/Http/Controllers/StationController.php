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

    /**
     * @SWG\Get(
     *      path="/stations",
     *      operationId="getStations",
     *      tags={"Stations"},
     *      summary="Get list of stations",
     *      description="Returns list of stations",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Station"),
     *       ),
     *       @SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       }
     *     )
     * Returns list of stations
     */
    public function index()
    {
        return Station::all();
    }

    /**
     * @SWG\Get(
     * 		path="/radius",
     * 		tags={"Stations"},
     * 		operationId="getByRadius",
     * 		summary="Get stations by given place and radius",
     * 		@SWG\Parameter(
     * 			name="latitude",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 		),
     * 		@SWG\Parameter(
     * 			name="longitude",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 		),
     * 		@SWG\Parameter(
     * 			name="radius",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 		),
     * 		@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Station"),
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function radius(Request $request)
    {
        return $this->stationService->getByRadius($request);
    }

    /**
     * @SWG\Get(
     * 		path="/stations/{id}",
     * 		tags={"Stations"},
     * 		operationId="getStation",
     * 		summary="Fetch station details",
     * 		@SWG\Parameter(
     * 			name="id",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 			description="UUID",
     * 		),
     * 		@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Station"),
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function show(Station $station)
    {
        return $station;
    }

    /**
     *
     * @SWG\Post(
     * 		path="/stations",
     * 		tags={"Stations"},
     * 		operationId="createStation",
     * 		summary="Create new station entry",
     * 		@SWG\Parameter(
     * 			name="station",
     * 			in="body",
     * 			required=true,
     *          @SWG\Schema(ref="#/definitions/Station"),
     *		),
     * 		@SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function store(Request $request)
    {
        $station = Station::create($request->all());

        return response()->json($station, 201);
    }


    /**
     *
     * 	@SWG\Put(
     * 		path="/stations/{id}",
     * 		tags={"Stations"},
     * 		operationId="updateStation",
     * 		summary="Update station entry",
     * 		@SWG\Parameter(
     * 			name="id",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 			description="UUID",
     * 		),
     * 		@SWG\Parameter(
     * 			name="station",
     * 			in="body",
     * 			required=true,
     *          @SWG\Schema(ref="#/definitions/Station"),
     *		),
     * 		@SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function update(Request $request, Station $station)
    {
        $station->update($request->all());

        return response()->json($station, 200);
    }

    /**
     *
     * 	@SWG\Delete(
     * 		path="/stations/{id}",
     * 		tags={"Stations"},
     * 		operationId="deleteStation",
     * 		summary="Remove station entry",
     * 		@SWG\Parameter(
     * 			name="id",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 			description="UUID",
     * 		),
     * 		@SWG\Response(
     * 			response=200,
     * 			description="success",
     * 		),
     * 		@SWG\Response(
     * 			response="default",
     * 			description="error",
     * 			@SWG\Schema(ref="#/definitions/Station"),
     * 		),
     * 	)
     *
     */
    public function delete(Station $station)
    {
        $station->delete();

        return response()->json(null, 204);
    }
}
