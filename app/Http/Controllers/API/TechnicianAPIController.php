<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTechnicianAPIRequest;
use App\Http\Requests\API\UpdateTechnicianAPIRequest;
use App\Models\Technician;
use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TechnicianController
 * @package App\Http\Controllers\API
 */

class TechnicianAPIController extends AppBaseController
{
    /** @var  TechnicianRepository */
    private $technicianRepository;

    public function __construct(TechnicianRepository $technicianRepo)
    {
        $this->technicianRepository = $technicianRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/technicians",
     *      summary="Get a listing of the Technicians.",
     *      tags={"Technician"},
     *      description="Get all Technicians",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Technician")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $technicians = $this->technicianRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($technicians->toArray(), 'Technicians retrieved successfully');
    }

    /**
     * @param CreateTechnicianAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/technicians",
     *      summary="Store a newly created Technician in storage",
     *      tags={"Technician"},
     *      description="Store Technician",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Technician that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Technician")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Technician"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTechnicianAPIRequest $request)
    {
        $input = $request->all();

        $technician = $this->technicianRepository->create($input);

        return $this->sendResponse($technician->toArray(), 'Technician saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/technicians/{id}",
     *      summary="Display the specified Technician",
     *      tags={"Technician"},
     *      description="Get Technician",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Technician",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Technician"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Technician $technician */
        $technician = $this->technicianRepository->find($id);

        if (empty($technician)) {
            return $this->sendError('Technician not found');
        }

        return $this->sendResponse($technician->toArray(), 'Technician retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTechnicianAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/technicians/{id}",
     *      summary="Update the specified Technician in storage",
     *      tags={"Technician"},
     *      description="Update Technician",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Technician",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Technician that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Technician")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Technician"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTechnicianAPIRequest $request)
    {
        $input = $request->all();

        /** @var Technician $technician */
        $technician = $this->technicianRepository->find($id);

        if (empty($technician)) {
            return $this->sendError('Technician not found');
        }

        $technician = $this->technicianRepository->update($input, $id);

        return $this->sendResponse($technician->toArray(), 'Technician updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/technicians/{id}",
     *      summary="Remove the specified Technician from storage",
     *      tags={"Technician"},
     *      description="Delete Technician",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Technician",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Technician $technician */
        $technician = $this->technicianRepository->find($id);

        if (empty($technician)) {
            return $this->sendError('Technician not found');
        }

        $technician->delete();

        return $this->sendSuccess('Technician deleted successfully');
    }
}
