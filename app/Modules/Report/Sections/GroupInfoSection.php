<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;

class GroupInfoSection implements PdfSectionContract
{
    public function __construct(
        protected ReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.group-info";
    }

    public function data(): array
    {
        $group = $this->context->group;

        return [
            'title' => $group->titleGroup,
            'username' => $group->findGroup,
            'participants' => $group->participantsCount,
            'createdAt' => $group->createdDate?->format('d.m.Y'),
            'lastUpdate' => $group->lastUpdate?->format('d.m.Y H:i'),
            'description' => $group->infoGroup,
            'flags' => $group->flags,
        ];
    }
}
