<?php

namespace App\Services\Classes\Bookmark;

use App\Exceptions\CustomException;
use App\Http\Requests\BookmarkRequest;

interface BookmarkServiceInterface
{
    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function coin(BookmarkRequest $request);

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function market(BookmarkRequest $request);

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function strategy(BookmarkRequest $request);

    /**
     * @param BookmarkRequest $request
     * @throws CustomException
     */
    public function ideaOrNews(BookmarkRequest $request);

    /**
     * @param $bookmarkable_id
     * @param $bookmarkable_type
     */
    public function removeBookmarkByAttributes($bookmarkable_id, $bookmarkable_type);
}
