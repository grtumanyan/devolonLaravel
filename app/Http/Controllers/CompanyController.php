<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     @SWG\SecurityScheme(
 *         securityDefinition="api_token",
 *         type="apiKey",
 *         name="api_token",
 *         in="query"
 *     ),
 * 		@SWG\Definition(
 * 			definition="Company",
 * 			required={"name", "parent"},
 * 			@SWG\Property(property="id", type="string", description="UUID"),
 * 			@SWG\Property(property="name", type="string"),
 * 			@SWG\Property(property="parent", type="string"),
 * 		),
 * 		@SWG\Definition(
 * 			definition="Station",
 * 			required={"name", "latitude", "longitude", "company"},
 * 			@SWG\Property(property="id", type="string", description="UUID"),
 * 			@SWG\Property(property="name", type="string"),
 * 			@SWG\Property(property="latitude", type="string"),
 * 			@SWG\Property(property="longitude", type="string"),
 * 			@SWG\Property(property="company", type="string"),
 * 		),
 *     host="localhost/devolon/public",
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API",
 *         description="Api",
 *         termsOfService="",
 *         @SWG\License(
 *             name="MIT"
 *         )
 *     )
 * )
 */

class CompanyController extends Controller
{

    /**
     * @SWG\Get(
     *      path="/companies",
     *      operationId="getCompanies",
     *      tags={"Companies"},
     *      summary="Get list of companies",
     *      description="Returns list of companies",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(ref="#/definitions/Company"),
     *       ),
     *       @SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       }
     *     )
     * Returns list of companies
     */
    public function index()
    {
        return Company::all();
    }

    /**
     * @SWG\Get(
     * 		path="/companies/{id}",
     * 		tags={"Companies"},
     * 		operationId="getCompany",
     * 		summary="Fetch company details",
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
     *          @SWG\Schema(ref="#/definitions/Company"),
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function show(Company $company)
    {
        return $company;
    }

    /**
     * @SWG\Get(
     * 		path="/companies/tree/{id}",
     * 		tags={"Companies"},
     * 		operationId="getTree",
     * 		summary="Get stations tree by companyId",
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
     *          @SWG\Schema(ref="#/definitions/Company"),
     *       ),
     * 		@SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_token": {}}
     *       },
     * 	)
     *
     */
    public function tree(Company $company)
    {
        return response()->json($company->allChildren()->get());
    }

    /**
     *
     * @SWG\Post(
     * 		path="/companies",
     * 		tags={"Companies"},
     * 		operationId="createCompany",
     * 		summary="Create new company entry",
     * 		@SWG\Parameter(
     * 			name="company",
     * 			in="body",
     * 			required=true,
     *          @SWG\Schema(ref="#/definitions/Company"),
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
        $company = Company::create($request->all());

        return response()->json($company, 201);
    }

    /**
     *
     * 	@SWG\Put(
     * 		path="/companies/{id}",
     * 		tags={"Companies"},
     * 		operationId="updateCompany",
     * 		summary="Update company entry",
     * 		@SWG\Parameter(
     * 			name="id",
     * 			in="path",
     * 			required=true,
     * 			type="string",
     * 			description="UUID",
     * 		),
     * 		@SWG\Parameter(
     * 			name="company",
     * 			in="body",
     * 			required=true,
     *          @SWG\Schema(ref="#/definitions/Company"),
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
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return response()->json($company, 200);
    }

    /**
     *
     * 	@SWG\Delete(
     * 		path="/companies/{id}",
     * 		tags={"Companies"},
     * 		operationId="deleteCompany",
     * 		summary="Remove company entry",
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
     * 			@SWG\Schema(ref="#/definitions/Company"),
     * 		),
     * 	)
     *
     */
    public function delete(Company $company)
    {
        $company->delete();

        return response()->json(null, 204);
    }
}
