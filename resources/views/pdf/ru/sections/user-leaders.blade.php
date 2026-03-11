<div class="section page-break">

    <div class="section-title">1. Лидеры активности и ключевые участники</div>
    <p>
        Раздел направлен на выявление наиболее активных пользователей сообщества, формирующих значительную часть публикаций и взаимодействий.
        Показатели помогают определить участников, оказывающих наибольшее влияние на активность сообщества.
    </p>

    {{-- 1.1 Топ-10 пользователей по сообщениям --}}
    <div class="subsection-title">1.1 Топ-10 пользователей по количеству сообщений</div>
    @if(!empty($messageChart))
        <div class="chart-container">
            <img src="{{ $messageChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <table class="leaders-table">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Сообщения</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top10ByMessage as $userId => $count)
                <tr>
                    <td>{{ $userId }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 1.2 Топ-10 пользователей по реакциям --}}
    <div class="subsection-title">1.2 Топ-10 пользователей по количеству реакций</div>
    @if(!empty($reactionChart))
        <div class="chart-container">
            <img src="{{ $reactionChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <table class="leaders-table">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Реакции</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top10ByReaction as $userId => $count)
                <tr>
                    <td>{{ $userId }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 1.3 Топ-10 пользователей по совокупной активности --}}
    <div class="subsection-title">1.3 Топ-10 пользователей по совокупной активности</div>
    @if(!empty($totalChart))
        <div class="chart-container">
            <img src="{{ $totalChart }}" style="width:100%; margin-top:10px;">
        </div>
    @endif

    <table class="leaders-table">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Общая активность</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top10ByTotal as $userId => $count)
                <tr>
                    <td>{{ $userId }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
