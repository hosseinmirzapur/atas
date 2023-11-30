<?php


namespace App\Services\Classes\Report;


use App\Exceptions\CustomException;
use App\Http\Requests\ChangeReportStatusRequest;
use App\Http\Requests\ReportRequest;
use App\Repository\Structure\CommentRepository;
use App\Repository\Structure\IdeaRepository;
use App\Repository\Structure\ReportRepository;
use App\Repository\Structure\UserRepository;

class ReportService implements ReportServiceInterface
{
    protected ReportRepository $reportRepository;
    protected IdeaRepository $ideaRepository;
    protected UserRepository $userRepository;
    protected CommentRepository $commentRepository;

    /**
     * ReportService constructor.
     * @param ReportRepository $reportRepository
     * @param IdeaRepository $ideaRepository
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(ReportRepository $reportRepository, IdeaRepository $ideaRepository, UserRepository $userRepository, CommentRepository $commentRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->ideaRepository = $ideaRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function ideaOrNews(ReportRequest $request)
    {
        $this->ideaRepository->findOneById($request->reportable_id);
        $this->reportRepository->createOne([
            'text' => $request->text,
            'reportable_id' => $request->reportable_id,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function user(ReportRequest $request)
    {
        $this->userRepository->findOneById($request->reportable_id);
        $this->reportRepository->createOne([
            'text' => $request->text,
            'reportable_id' => $request->reportable_id,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function comment(ReportRequest $request)
    {
        $this->commentRepository->findOneById($request->reportable_id);
        $this->reportRepository->createOne([
            'text' => $request->text,
            'reportable_id' => $request->reportable_id,
            'user_id' => currentUser()->id
        ]);
    }

    /**
     * @param ChangeReportStatusRequest $request
     * @throws CustomException
     */
    public function changeStatus(ChangeReportStatusRequest $request)
    {
        $report = $this->reportRepository->findOneById($request->report_id);
        $this->reportRepository->updateById($report->id, [
            'status' => $request->status
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->reportRepository->deleteById($id);
    }
}
