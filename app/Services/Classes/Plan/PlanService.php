<?php


namespace App\Services\Classes\Plan;


use App\Exceptions\CustomException;
use App\Http\Requests\GrantOptionsToPlanRequest;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanResource;
use App\Repository\Structure\OptionRepository;
use App\Repository\Structure\PlanRepository;
use JetBrains\PhpStorm\ArrayShape;

class PlanService implements PlanServiceInterface
{
    protected PlanRepository $planRepository;
    protected OptionRepository $optionRepository;

    public function __construct(PlanRepository $planRepository, OptionRepository $optionRepository)
    {
        $this->planRepository = $planRepository;
        $this->optionRepository = $optionRepository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['plans' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function all(): array
    {
        $plans = $this->planRepository->findAll(['options']);
        return [
            'plans' => PlanResource::collection($plans)
        ];
    }

    /**
     * @param PlanRequest $request
     * @throws CustomException
     */
    public function create(PlanRequest $request)
    {
        $data = $request->validated();
        $data['image'] = handleFile('/plans', $data['image']);
        $this->planRepository->createOne($data);
    }

    /**
     * @param $id
     * @return array
     */
    #[ArrayShape(['plan' => "\App\Http\Resources\PlanResource"])] public function show($id): array
    {
        $plan = $this->planRepository->findOneById($id, ['option']);
        return [
            'plan' => PlanResource::make($plan)
        ];
    }

    /**
     * @param PlanRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(PlanRequest $request, $id)
    {
        $data = filterRequest($request->validated());
        if (exists($data['image'])) {
            $data['image'] = handleFile('/plans', $data['image']);
        }
        $this->planRepository->updateById($id, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->planRepository->forceDeleteById($id);
    }

    /**
     * @param GrantOptionsToPlanRequest $request
     */
    public function grantOptionsToPlan(GrantOptionsToPlanRequest $request)
    {
        foreach ($request->option_ids as $id) {
            $this->optionRepository->findOneById($id);
        }
        $plan = $this->planRepository->findOneById($request->plan_id);
        $plan->options()->sync($request->option_ids);
    }
}
