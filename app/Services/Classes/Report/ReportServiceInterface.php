<?php

namespace App\Services\Classes\Report;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeReportStatusRequest;
use App\Http\Requests\ReportRequest;

interface ReportServiceInterface
{
    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function ideaOrNews(ReportRequest $request);

    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function user(ReportRequest $request);

    /**
     * @param ReportRequest $request
     * @throws CustomException
     */
    public function comment(ReportRequest $request);

    /**
     * @param ChangeReportStatusRequest $request
     */
    public function changeStatus(ChangeReportStatusRequest $request);

    /**
     * @param $id
     */
    public function delete($id);
}
