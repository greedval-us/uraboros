<?php

namespace App\Modules\Report\Pdf;

use App\Modules\Report\Enums\ReportType;
use App\Modules\Report\Sections\AudienceQualitySection;
use App\Modules\Report\Sections\BasicMetricsSection;
use App\Modules\Report\Sections\FooterSection;
use App\Modules\Report\Sections\FullIntroSection;
use App\Modules\Report\Sections\FunnelSection;
use App\Modules\Report\Sections\GroupInfoSection;
use App\Modules\Report\Sections\HeaderSection;
use App\Modules\Report\Sections\IntroSection;
use App\Modules\Report\Sections\NetworkMetricsSection;
use App\Modules\Report\Sections\RetentionSection;
use App\Modules\Report\Sections\UserLeadersSection;
use App\Modules\Report\Sections\UserSection;

class ReportSectionsResolver
{
    public function resolve(ReportType $type, object $context): array
    {
        return match ($type) {
            ReportType::BASIC => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new BasicMetricsSection($context),
                new FooterSection($context),
            ],

            ReportType::AUDIENCE => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new AudienceQualitySection($context),
                new FooterSection($context),
            ],

            ReportType::FUNNEL => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new FunnelSection($context),
                new FooterSection($context),
            ],

            ReportType::USERLEADERS => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new UserLeadersSection ($context),
                new FooterSection($context),
            ],

            ReportType::NETWORK => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new NetworkMetricsSection($context),
                new FooterSection($context),
            ],

            ReportType::RETENTION => [
                new HeaderSection($context),
                new IntroSection($context),
                new GroupInfoSection($context),
                new RetentionSection($context),
                new FooterSection($context),
            ],

            ReportType::FULLREPORT => [
                new HeaderSection($context),
                new FullIntroSection($context),
                new GroupInfoSection($context),
                new BasicMetricsSection($context),
                new FunnelSection($context),
                new AudienceQualitySection($context),
                new UserLeadersSection ($context),
                new FooterSection($context),
            ],

            ReportType::USERREPORT => [
                new HeaderSection($context),
                new UserSection($context),
                new FooterSection($context),
            ],

            ReportType::DEFAULT => [
                new HeaderSection($context),
                new FooterSection($context),
            ],
        };
    }
}
