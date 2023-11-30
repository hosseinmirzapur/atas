<?php


namespace App\Services\Classes\FAQ;


use App\Http\Requests\FaqRequest;
use App\Repository\Structure\FaqRepository;
use JetBrains\PhpStorm\ArrayShape;

class FaqService implements FaqServiceInterface
{
    protected FaqRepository $faqRepository;

    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * @return array
     */
    #[ArrayShape(['faq' => "mixed"])] public function showLast(): array
    {
        return [
            'faq' => $this->faqRepository->findAll()->last()
        ];
    }

    /**
     * @param FaqRequest $request
     */
    public function createNew(FaqRequest $request)
    {
        $this->faqRepository->createOne($request->validated());
    }
}
