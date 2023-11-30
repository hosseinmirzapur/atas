<?php


namespace App\Services\Classes\Billing;


use App\Exceptions\CustomException;
use App\Http\Requests\ChangeBillingStatusRequest;
use App\Http\Requests\PayRequest;
use App\Http\Resources\BillingResource;
use App\Repository\Structure\BillingRepository;
use App\Repository\Structure\NetworkRepository;
use App\Repository\Structure\PaymentMethodRepository;
use App\Repository\Structure\PlanRepository;
use JetBrains\PhpStorm\ArrayShape;

class BillingService implements BillingServiceInterface
{

    protected BillingRepository $billingRepository;
    protected PlanRepository $planRepository;
    protected PaymentMethodRepository $paymentMethodRepository;
    protected NetworkRepository $networkRepository;

    public function __construct(
        BillingRepository $billingRepository,
        PlanRepository $planRepository,
        PaymentMethodRepository $paymentMethodRepository,
        NetworkRepository $networkRepository
    )
    {
        $this->billingRepository = $billingRepository;
        $this->planRepository = $planRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->networkRepository = $networkRepository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['billings' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function all(): array
    {
        $billings = $this->billingRepository->findAll();
        return [
            'billings' => BillingResource::collection($billings)
        ];
    }

    /**
     * @param PayRequest $request
     * @throws CustomException
     */
    public function pay(PayRequest $request)
    {
        $network = $this->networkRepository->findOneById($request->network_id);
        $plan = $this->planRepository->findOneById($request->plan_id);
        $paymentMethod = $this->paymentMethodRepository->findOneById($request->payment_method_id);
        $this->billingRepository->createOne([
            'plan_id' => $plan->id,
            'user_id' => currentUser()->id,
            'payment_method_id' => $paymentMethod->id,
            'network_id' => $network->id,
            'tx_id' => $request->tx_id
        ]);
    }

    public function changeBillingStatus(ChangeBillingStatusRequest $request)
    {
        $billing_id = $request->billing_id;
        $status = $request->status;
        $billing = $this->billingRepository->findOneById($billing_id);
        $this->handleBillingUser($billing, $status);
        $billing->update([
            'status' => $status
        ]);
    }

    protected function handleBillingUser($billing, $status)
    {
        $user = $billing->user;
        if ($status != $billing->status) {
            if ($billing->status == 'ACCEPTED') {
                $user->ranks->last()->delete();
            }
            if ($status == 'ACCEPTED') {
                $user->ranks()->create([
                    'plan_id' => $billing->plan_id
                ]);
            }
        }
    }
}
