<?php


namespace App\Services\Classes\Slider;


use App\Exceptions\CustomException;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\SliderResource;
use App\Repository\Structure\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class SliderService implements SliderServiceInterface
{
    protected SliderRepository $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @param Request $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['sliders' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function all(Request $request): array
    {
        $type = $this->handleNeededDataType($request);
        $sliders = $this->sliderRepository->findManyByAttr('type', $type);
        return [
            'sliders' => SliderResource::collection($sliders)
        ];
    }

    /**
     * @param SliderRequest $request
     * @throws CustomException
     */
    public function create(SliderRequest $request)
    {
        $data = filterRequest($request->validated());
        if (exists($data['image'])) {
            $data['image'] = handleFile('/sliders', $data['image']);
        }
        $this->sliderRepository->createOne($data);
    }

    /**
     * @param $id
     * @return array
     */
    #[ArrayShape(['slider' => "\App\Http\Resources\SliderResource"])] public function show($id): array
    {
        $slider = $this->sliderRepository->findOneById($id);
        return [
            'slider' => SliderResource::make($slider)
        ];
    }

    /**
     * @param SliderRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(SliderRequest $request, $id)
    {
        $data = filterRequest($request->validated());
        if (exists($data['image'])) {
            $data['image'] = handleFile('/sliders', $data['image']);
        }
        $this->sliderRepository->updateById($id, $data);
    }

    public function delete($id)
    {
        $this->sliderRepository->deleteById($id);
    }

    /**
     * @param Request $request
     * @return string|null
     * @throws CustomException
     */
    protected function handleNeededDataType(Request $request): ?string
    {
        if (!exists($request->query('type'))) {
            return null;
        } else if (Str::lower($request->query('type')) == 'mobile') {
            return "MOBILE";
        } else if (Str::lower($request->query('type')) == 'website') {
            return "WEBSITE";
        } else {
            throw new CustomException(trans('messages.INCOMPATIBLE_QUERY_STRING'));
        }
    }
}
