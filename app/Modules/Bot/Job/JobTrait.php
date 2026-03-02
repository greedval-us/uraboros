<?php

namespace App\Modules\Bot\Job;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Report\Pdf\PdfReportService;
use App\Modules\UraborosApi\Services\UraborosApiService;

trait JobTrait
{
    protected LangService $langServices;
    protected BotActionService $botServices;
    protected UraborosApiService $apiServices;
    protected DataMapperService $dataMapperService;
    protected PdfReportService $pdfReportServices;
    public function bootServices(): void
    {
        $this->langServices       = app(LangService::class);
        $this->botServices        = app(BotActionService::class);
        $this->apiServices        = app(UraborosApiService::class);
        $this->dataMapperService  = app(DataMapperService::class);
        $this->pdfReportServices  = app(PdfReportService::class);

    }
}
