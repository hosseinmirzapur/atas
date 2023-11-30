<?php


namespace App\Services\Classes\Bookmark;


use App\Exceptions\CustomException;
use App\Http\Requests\BookmarkRequest;
use App\Models\Bookmark;
use App\Models\Coin;
use App\Models\Idea;
use App\Models\Market;
use App\Models\Strategy;
use App\Repository\Structure\BookmarkRepository;
use App\Repository\Structure\CoinRepository;
use App\Repository\Structure\IdeaRepository;
use App\Repository\Structure\MarketRepository;
use App\Repository\Structure\StrategyRepository;

class BookmarkService implements BookmarkServiceInterface
{
    protected CoinRepository $coinRepository;
    protected MarketRepository $marketRepository;
    protected StrategyRepository $strategyRepository;
    protected IdeaRepository $ideaRepository;
    protected BookmarkRepository $bookmarkRepository;

    /**
     * BookmarkService constructor.
     * @param CoinRepository $coinRepository
     * @param MarketRepository $marketRepository
     * @param StrategyRepository $strategyRepository
     * @param IdeaRepository $ideaRepository
     * @param BookmarkRepository $bookmarkRepository
     */
    public function __construct(CoinRepository $coinRepository, MarketRepository $marketRepository, StrategyRepository $strategyRepository, IdeaRepository $ideaRepository, BookmarkRepository $bookmarkRepository)
    {
        $this->coinRepository = $coinRepository;
        $this->marketRepository = $marketRepository;
        $this->strategyRepository = $strategyRepository;
        $this->ideaRepository = $ideaRepository;
        $this->bookmarkRepository = $bookmarkRepository;
    }


    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function coin(BookmarkRequest $request)
    {
        $this->coinRepository->findOneById($request->bookmarkable_id);
        $this->bookmarkRepository->createOne([
            'bookmarkable_id' => $request->bookmarkable_id,
            'bookmarkable_type' => Coin::class,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function market(BookmarkRequest $request)
    {
        $this->marketRepository->findOneById($request->bookmarkable_id);
        $this->bookmarkRepository->createOne([
            'bookmarkable_id' => $request->bookmarkable_id,
            'bookmarkable_type' => Market::class,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function strategy(BookmarkRequest $request)
    {
        $this->strategyRepository->findOneById($request->bookmarkable_id);
        $this->bookmarkRepository->createOne([
            'bookmarkable_id' => $request->bookmarkable_id,
            'bookmarkable_type' => Strategy::class,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function ideaOrNews(BookmarkRequest $request)
    {
        $this->ideaRepository->findOneById($request->bookmarkable_id);
        $this->bookmarkRepository->createOne([
            'bookmarkable_id' => $request->bookmarkable_id,
            'bookmarkable_type' => Idea::class,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param $bookmarkable_id
     * @param $bookmarkable_type
     */
    public function removeBookmarkByAttributes($bookmarkable_id, $bookmarkable_type)
    {
        $bookmark = Bookmark::query()
            ->where('bookmarkable_id', $bookmarkable_id)
            ->where('bookmarkable_type', $bookmarkable_type)
            ->where('user_id' , currentUser()->id)
            ->firstOrFail();
        $bookmark->forceDelete();
    }

}
