<?php


namespace App\Services\Classes\News;


use App\Exceptions\CustomException;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\IdeaDetailResource;
use App\Http\Resources\IdeaResource;
use App\Models\Idea;
use App\Models\Tag;
use App\Repository\Structure\CoinRepository;
use App\Repository\Structure\IdeaRepository;
use App\Repository\Structure\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class NewsService implements NewsServiceInterface
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
    #[ArrayShape(['ideas' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function allForAdmin(Request $request): array
    {
        $type = $this->handleType($request);
        $type1 = $type[0];
        $type2 = $type[1];
        $ideas = Idea::query()
            ->where('type1', $type1)
            ->where('type2', $type2)
            ->where('entity_type', '=', 'NEWS')
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
     * @throws CustomException
     */
    public function create(IdeaRequest $request)
    {
        $this->coinRepository->findOneById($request->coin_id);
        $filePath = handleFile('/news', $request->file);

        $idea = $this->ideaRepository->createOne([
            'idea_file' => $filePath,
            'idea_file_type' => $this->getFileType($request->file('file')->getClientOriginalExtension()),
            'title' => $request->title,
            'description' => $request->caption,
            'link' => $request->related_link,
            'category' => $request->category,
            'privacy_settings' => $this->getPrivacyType($request->private),
            'entity_type' => 'NEWS',
            'idea_first_type' => $request->type1,
            'idea_second_type' => $request->type2,
            'investment_type' => $request->strategy,
            'time_frame' => $request->time_frame,
            'coin_id' => $request->coin_id
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
     * @param UpdateNewsRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateNewsRequest $request, $id)
    {
        $updateData = [];
        $data = $request->validated();
        $news = $this->ideaRepository->findOneById($id);
        if ($request->has('idea_file')) {
            $filePath = handleFile('/news', $request->file('idea_file'));
            $fileType = $this->getFileType($request->file('idea_file')->getClientOriginalExtension());
            $updateData += [
                'idea_file' => $filePath,
                'idea_file_type' => $fileType
            ];
            unset($data['idea_file']);
        }
        $updateData += $data;
        if ($request->has('tags')) {
            $tags = new Collection(formatTags($request->tags));
            Tag::query()
                ->where('taggable_id', $news->id)
                ->where('taggable_type', Idea::class)
                ->whereNull('user_id')
                ->delete();
            $tags->map(function ($tag) use ($news) {
                $this->tagRepository->createOne([
                    'title' => $tag,
                    'taggable_id' => $news->id,
                    'taggable_type' => Idea::class
                ]);
            });
        }
        $this->ideaRepository->updateById($id, $updateData);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->ideaRepository->deleteById($id);
    }

    /**
     * @param Request $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['ideas' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function forUsers(Request $request): array
    {
        $type = $this->handleType($request);
        $type1 = $type[0];
        $type2 = $type[1];
        $ideas = Idea::query()
            ->where('type1', $type1)
            ->where('type2', $type2)
            ->where('status', '=', 'ACCEPTED')
            ->where('entity_type', '=', 'NEWS')
            ->get();
        return [
            'ideas' => IdeaResource::collection($ideas)
        ];
    }

}
