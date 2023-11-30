<?php


namespace App\Services\Classes\PaymentMethod;


use App\Exceptions\CustomException;
use App\Http\Requests\PaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Repository\Structure\PaymentMethodRepository;
use JetBrains\PhpStorm\ArrayShape;

class PaymentMethodService implements PaymentMethodServiceInterface
{
    protected PaymentMethodRepository $methodRepository;

    public function __construct(PaymentMethodRepository $repository)
    {
        $this->methodRepository = $repository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['payment_methods' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function all(): array
    {
        $paymentMethods = $this->methodRepository->findAll();
        return [
            'payment_methods' => PaymentMethodResource::collection($paymentMethods)
        ];
    }

    /**
     * @throws CustomException
     */
    public function create(PaymentMethodRequest $request)
    {
        $this->methodRepository->createOne($request->validated());
    }

    /**
     * @param $id
     * @return array
     */
    #[ArrayShape(['payment_method' => "\App\Http\Resources\PaymentMethodResource"])] public function find($id): array
    {
        return [
            'payment_method' => PaymentMethodResource::make($this->methodRepository->findOneById($id))
        ];
    }

    /**
     * @throws CustomException
     */
    public function update(PaymentMethodRequest $request, $id)
    {
        $this->methodRepository->updateById($id, $request->validated());
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->methodRepository->deleteById($id);
    }
}
