<?php


namespace App\Services\Classes\Idea;


use App\Exceptions\CustomException;
use App\Http\Requests\ChangeIdeaRequest;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Http\Resources\IdeaDetailResource;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use App\Repository\Structure\CoinRepository;
use App\Repository\Structure\IdeaRepository;
use App\Repository\Structure\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class IdeaService implements IdeaServiceInterface
{

    protected IdeaRepository $ideaRepository;
    protected CoinRepository $coinRepository;
    protected TagRepository $tagRepository;

    public function __construct(IdeaRepository $ideaRepository, CoinRepository $coinRepository, TagRepository $tagRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->coinRepository = $coinRepository;
        $this->tagRepository = $tagRepository;
    }


    /**
     * @throws CustomException
     */
    #[ArrayShape(['ideas' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function allForUser(Request $request): array
    {
        $type = $this->handleType($request);
        $type1 = $type[0];
        $type2 = $type[1];
        $ideas = Idea::query()
            ->where('idea_first_type', $type1)
            ->where('idea_second_type', $type2)
            ->where('status', '=', 'ACCEPTED')
            ->where('entity_type', '=', 'IDEA')
            ->where('privacy_settings', '=', 'PUBLIC')
            ->get();
        return [
            'ideas' => IdeaResource::collection($ideas)
        ];
    }

    /**
     * @param Request $request
     * @return string[]
     * @throws CustomException
     */
    protected function handleType(Request $request): array
    {
        $type = $request->query('type');
        if (!in_array($type, Idea::TYPES)) {
            throw new CustomException(trans('messages.INCOMPATIBLE_QUERY_STRING'));
        }
        return match ($type) {
            "FA" => ['ANALYSIS', 'FUNDAMENTAL'],
            "TA" => ['ANALYSIS', 'TECHNICAL'],
            "FE" => ['TUTORIAL', 'FUNDAMENTAL'],
            "TE" => ['TUTORIAL', 'TECHNICAL']
        };
    }

    /**
     * @param $id
     * @return array
     */
    #[ArrayShape(['idea' => "\App\Http\Resources\IdeaDetailResource"])] public function show($id): array
    {
        $idea = $this->ideaRepository->findOneById($id);
        return [
            'idea' => IdeaDetailResource::make($idea)
        ];
    }

    /**
     * @param IdeaRequest $request
     * @throws CustomException
     */
    public function create(IdeaRequest $request)
    {
        $this->coinRepository->findOneById($request->coin_id);
        $filePath = handleFile('/ideas', $request->file);

        $idea = $this->ideaRepository->createOne([
            'idea_file' => $filePath,
            'idea_file_type' => $this->getFileType($request->file('file')->getClientOriginalExtension()),
            'title' => $request->title,
            'description' => $request->caption,
            'link' => $request->related_link,
            'category' => $request->category,
            'privacy_settings' => $this->getPrivacyType($request->private),
            'entity_type' => 'IDEA',
            'idea_first_type' => $request->type1,
            'idea_second_type' => $request->type2,
            'investment_type' => $request->strategy,
            'time_frame' => $request->time_frame,
            'coin_id' => $request->coin_id,
            'user_id' => currentUser()->id
        ]);
        $tags = new Collection(formatTags($request->tags));
        $tags->map(function ($tag) use ($idea) {
            $this->tagRepository->createOne([
                'title' => $tag,
                'taggable_id' => $idea->id,
                'taggable_type' => Idea::class,
                'user_id' => currentUser()->id
            ]);
        });
    }

    /**
     * @param $extension
     * @return string
     * @throws CustomException
     */
    protected function getFileType($extension): string
    {
        if (in_array($extension, Idea::SUPPORTED_IMAGE_TYPES)) {
            return 'IMAGE';
        } else if (in_array($extension, Idea::SUPPORTED_VIDEO_TYPES)) {
            return 'VIDEO';
        } else {
            throw new CustomException(trans('messages.UNSUPPORTED_FILETYPE'));
        }
    }

    /**
     * @param $indicator
     * @return string
     * @throws CustomException
     */
    protected function getPrivacyType($indicator): string
    {
        if ($indicator == false || $indicator == 'false') {
            return 'PUBLIC';
        } else if ($indicator == true || $indicator == 'true') {
            return 'PRIVATE';
        } else {
            throw new CustomException(trans('messages.UNSUPPORTED_PRIVACY_TYPE'));
        }
    }

    /**
     * @param UpdateIdeaRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateIdeaRequest $request, $id)
    {
        $this->ideaRepository->updateById($id, $request->validated());
    }

    /**
     * @param $id
     * @throws CustomException
     */
    public function delete($id)
    {
        $idea = $this->ideaRepository->findOneById($id);
        if (!$this->canBeDeleted($idea->created_at)) {
            throw new CustomException(trans('messages.DELETE_TIME_EXPIRED'));
        }
        $this->ideaRepository->deleteById($id);
    }

    /**
     * @param string $created_at
     * @return bool
     */
    protected function canBeDeleted(string $created_at): bool
    {
        return now()->diffInMinutes($created_at) < 15;
    }

    /**
     * @param ChangeIdeaRequest $request
     * @throws CustomException
     */
    public function changeStatus(ChangeIdeaRequest $request)
    {
        $this->ideaRepository->updateById($request->idea_id, [
            'status' => $request->status
        ]);
    }
}
