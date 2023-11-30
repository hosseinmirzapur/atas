<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeReportStatusRequest;
use App\Http\Requests\ReportRequest;
use App\Services\Classes\Report\ReportServiceInterface;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    protected ReportServiceInterface $service;

    public function __construct(ReportServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param ReportRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function ideaOrNews(ReportRequest $request): JsonResponse
    {
        $this->service->ideaOrNews($request);
        return jsonResponse();
    }

    /**
     * @param ReportRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function user(ReportRequest $request): JsonResponse
    {
        $this->service->user($request);
        return jsonResponse();
    }

    /**
     * @param ReportRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function comment(ReportRequest $request): JsonResponse
    {
        $this->service->comment($request);
        return jsonResponse();
    }

    /**
     * @param ChangeReportStatusRequest $request
     * @return JsonResponse
     */
    public function changeStatus(ChangeReportStatusRequest $request): JsonResponse
    {
        $this->service->changeStatus($request);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }
}
