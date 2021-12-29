<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCarAPIRequest;
use App\Http\Requests\API\UpdateCarAPIRequest;
use App\Models\Car;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CarController
 * @package App\Http\Controllers\API
 */

class CarAPIController extends AppBaseController
{
    /** @var  CarRepository */
    private $carRepository;

    public function __construct(CarRepository $carRepo)
    {
        $this->carRepository = $carRepo;
    }

    /**
     * Display a listing of the Car.
     * GET|HEAD /cars
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
//        return "test";

        $cars = $this->carRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cars->toArray(), 'Cars retrieved successfully');
    }

    /**
     * Store a newly created Car in storage.
     * POST /cars
     *
     * @param CreateCarAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCarAPIRequest $request)
    {
        $input = $request->all();

        $car = $this->carRepository->create($input);

        return $this->sendResponse($car->toArray(), 'Car saved successfully');
    }

    /**
     * Display the specified Car.
     * GET|HEAD /cars/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Car $car */
        $car = $this->carRepository->find($id);

        if (empty($car)) {
            return $this->sendError('Car not found');
        }

        return $this->sendResponse($car->toArray(), 'Car retrieved successfully');
    }

    /**
     * Update the specified Car in storage.
     * PUT/PATCH /cars/{id}
     *
     * @param int $id
     * @param UpdateCarAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarAPIRequest $request)
    {
        $input = $request->all();

        /** @var Car $car */
        $car = $this->carRepository->find($id);

        if (empty($car)) {
            return $this->sendError('Car not found');
        }

        $car = $this->carRepository->update($input, $id);

        return $this->sendResponse($car->toArray(), 'Car updated successfully');
    }

    /**
     * Remove the specified Car from storage.
     * DELETE /cars/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Car $car */
        $car = $this->carRepository->find($id);

        if (empty($car)) {
            return $this->sendError('Car not found');
        }

        $car->delete();

        return $this->sendSuccess('Car deleted successfully');
    }
}
