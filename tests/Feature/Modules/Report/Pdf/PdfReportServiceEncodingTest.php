<?php

namespace Tests\Feature\Modules\Report\Pdf;

use App\Modules\Bot\DTO\BasicMetriicsDTO;
use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Report\DTO\BasicMetricsContextDTO;
use App\Modules\Report\Enums\ReportType;
use App\Modules\Report\Pdf\PdfReportService;
use Carbon\Carbon;
use Tests\TestCase;

class PdfReportServiceEncodingTest extends TestCase
{
    protected PdfReportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(PdfReportService::class);
    }

    public function test_pdf_generation_with_cyrillic_group_info()
    {
        // Создаём mock-данные с кириллицей
        $groupData = [
            'id' => 1,
            'idGroup' => 123456,
            'titleGroup' => 'Развитие мобильных приложений',
            'findGroup' => '@dev_mobile',
            'infoGroup' => 'Группа для обсуждения разработки мобильных приложений на Flutter и React Native',
            'participantsCount' => 1500,
            'createdDate' => '2023-01-15T10:30:00Z',
            'lastUpdate' => '2024-03-26T15:45:00Z',
        ];

        $basicMetricsData = [
            'allActiveUsers' => 350,
            'activeUsersPerComments' => 145,
            'activeUsersPerReactions' => 200,
            'activeUsersPerCommentsAndReactions' => 89,
            'allPublications' => 2500,
            'publicationsFromAdmin' => 450,
            'publicationsFromUser' => 2050,
            'commentsPerPost' => 3.5,
            'reactionsPerPost' => 8.2,
            'engagementRate' => 23.5,
            'allActiveUsersPeriod' => [],
            'activeUsersPerCommentsPeriod' => [],
            'activeUsersPerReactionsPeriod' => [],
            'activeUsersPerCommAndReactPeriod' => [],
            'allPublicationsPeriod' => [],
            'publicationsFromAdminPeriod' => [],
            'publicationsFromUserPeriod' => [],
            'commentsPerPostPeriod' => [],
            'reactionsPerPostPeriod' => [],
            'engagementRatePeriod' => [],
            'participantChanged' => [],
        ];

        // Создаём DTOs с кириллицей
        $groupDto = GroupDTO::fromApi($groupData);
        $basicMetricsDto = BasicMetriicsDTO::fromApi($basicMetricsData);

        $context = new BasicMetricsContextDTO(
            group: $groupDto,
            basicMetriicsDTO: $basicMetricsDto,
            lang: 'ru',
            days: 7,
            to: Carbon::now()->format('d.m.Y'),
            from: Carbon::yesterday()->subDays(6)->format('d.m.Y'),
        );

        // Генерируем PDF
        $pdf = $this->service->generate($context, ReportType::BASIC);

        $this->assertNotNull($pdf);
        $this->assertTrue(mb_check_encoding($groupDto->titleGroup, 'UTF-8'));
        $this->assertTrue(mb_check_encoding($groupDto->infoGroup, 'UTF-8'));
    }

    public function test_pdf_generation_preserves_encoding()
    {
        $groupData = [
            'id' => 1,
            'idGroup' => 789012,
            'titleGroup' => 'Тестовая группа для проверки кодировки',
            'findGroup' => '@test_encoding',
            'infoGroup' => 'Описание: проверяем правильную обработку символов кириллицы, включая: ё, ю, ж, ч, ш, щ',
            'participantsCount' => 500,
            'createdDate' => '2024-01-01T00:00:00Z',
        ];

        $basicMetricsData = [
            'allActiveUsers' => 100,
            'activeUsersPerComments' => 50,
            'activeUsersPerReactions' => 60,
            'activeUsersPerCommentsAndReactions' => 30,
            'allPublications' => 500,
            'publicationsFromAdmin' => 100,
            'publicationsFromUser' => 400,
            'commentsPerPost' => 2.5,
            'reactionsPerPost' => 5.0,
            'engagementRate' => 15.0,
            'allActiveUsersPeriod' => [],
            'activeUsersPerCommentsPeriod' => [],
            'activeUsersPerReactionsPeriod' => [],
            'activeUsersPerCommAndReactPeriod' => [],
            'allPublicationsPeriod' => [],
            'publicationsFromAdminPeriod' => [],
            'publicationsFromUserPeriod' => [],
            'commentsPerPostPeriod' => [],
            'reactionsPerPostPeriod' => [],
            'engagementRatePeriod' => [],
            'participantChanged' => [],
        ];

        $groupDto = GroupDTO::fromApi($groupData);
        $basicMetricsDto = BasicMetriicsDTO::fromApi($basicMetricsData);

        // Проверяем, что исходные данные в UTF-8
        $this->assertTrue(mb_check_encoding($groupData['titleGroup'], 'UTF-8'));
        $this->assertTrue(mb_check_encoding($groupData['infoGroup'], 'UTF-8'));

        $context = new BasicMetricsContextDTO(
            group: $groupDto,
            basicMetriicsDTO: $basicMetricsDto,
            lang: 'ru',
            days: 7,
            to: Carbon::now()->format('d.m.Y'),
            from: Carbon::yesterday()->subDays(6)->format('d.m.Y'),
        );

        // После создания контекста проверяем, что кодировка сохранилась
        $this->assertTrue(mb_check_encoding($context->group->titleGroup, 'UTF-8'));
        $this->assertTrue(mb_check_encoding($context->group->infoGroup, 'UTF-8'));

        // Генерируем PDF
        $pdf = $this->service->generate($context, ReportType::BASIC);

        $this->assertNotNull($pdf);
    }

    public function test_context_with_mixed_cyrillic_and_latin()
    {
        $groupData = [
            'id' => 1,
            'idGroup' => 111222,
            'titleGroup' => 'React Native Разработка',
            'findGroup' => '@react_dev',
            'infoGroup' => 'Community for React Native developers - Сообщество разработчиков React Native',
            'participantsCount' => 800,
        ];

        $basicMetricsData = [
            'allActiveUsers' => 200,
            'activeUsersPerComments' => 80,
            'activeUsersPerReactions' => 100,
            'activeUsersPerCommentsAndReactions' => 50,
            'allPublications' => 1500,
            'publicationsFromAdmin' => 200,
            'publicationsFromUser' => 1300,
            'commentsPerPost' => 3.0,
            'reactionsPerPost' => 6.5,
            'engagementRate' => 20.0,
            'allActiveUsersPeriod' => [],
            'activeUsersPerCommentsPeriod' => [],
            'activeUsersPerReactionsPeriod' => [],
            'activeUsersPerCommAndReactPeriod' => [],
            'allPublicationsPeriod' => [],
            'publicationsFromAdminPeriod' => [],
            'publicationsFromUserPeriod' => [],
            'commentsPerPostPeriod' => [],
            'reactionsPerPostPeriod' => [],
            'engagementRatePeriod' => [],
            'participantChanged' => [],
        ];

        $groupDto = GroupDTO::fromApi($groupData);
        $basicMetricsDto = BasicMetriicsDTO::fromApi($basicMetricsData);

        $context = new BasicMetricsContextDTO(
            group: $groupDto,
            basicMetriicsDTO: $basicMetricsDto,
            lang: 'ru',
            days: 7,
            to: Carbon::now()->format('d.m.Y'),
            from: Carbon::yesterday()->subDays(6)->format('d.m.Y'),
        );

        $pdf = $this->service->generate($context, ReportType::BASIC);

        $this->assertNotNull($pdf);
        $this->assertStringContainsString('React Native', $this->assertMbEncoding($groupDto->titleGroup));
        $this->assertStringContainsString('Разработка', $this->assertMbEncoding($groupDto->titleGroup));
    }

    private function assertMbEncoding(string $string): string
    {
        $this->assertTrue(mb_check_encoding($string, 'UTF-8'));
        return $string;
    }
}
