@php
    // Read plan start date and duration
    $startMonth = 1;
    if ($record->start_date) {
        try {
            $startMonth = \Carbon\Carbon::parse($record->start_date)->month;
        } catch (\Exception $e) {
            $startMonth = 1;
        }
    }
    
    // Use duration_in_months (absolute count of months in the plan)
    $planDuration = max(1, $record->duration_in_months ?? 12);

    $arabicMonths = [
        1 => 'يناير',   2 => 'فبراير',  3 => 'مارس',   4 => 'أبريل',
        5 => 'مايو',    6 => 'يونيو',   7 => 'يوليو',  8 => 'أغسطس',
        9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
    ];

    // Build plan slots: slot index (1..N) => calendar month number (1..12)
    // Using ABSOLUTE month values stored in DB (e.g. if start = May, slot 1 = val 5, slot 6 = val 10, slot 7 = val 11 ...)
    // The stored values match start_month offset: $startMonth + ($slot - 1)
    // Calendar month = (($startMonth + $slot - 2) % 12) + 1
    
    $planSlots = [];  // slot => ['abs' => absolute_val, 'calendar' => 1-12, 'label' => 'مايو']
    for ($slot = 1; $slot <= $planDuration; $slot++) {
        $absVal = $startMonth + $slot - 1;      // absolute value as stored in DB
        $calendarMonth = (($absVal - 1) % 12) + 1;
        $yearNum = (int)(($absVal - 1) / 12) + 1;
        $planSlots[$slot] = [
            'abs'      => $absVal,
            'calendar' => $calendarMonth,
            'label'    => $arabicMonths[$calendarMonth],
            'year'     => $yearNum,
        ];
    }
@endphp

<style>
    .gantt-wrapper {
        margin-top: 1rem;
        margin-bottom: 1rem;
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        border: 1px solid #e5e7eb;
    }
    .dark .gantt-wrapper {
        border-color: #374151;
        box-shadow: none;
    }
    .gantt-table {
        width: 100%;
        min-width: {{ 530 + ($planDuration * 55) }}px;
        border-collapse: collapse !important;
        background-color: #ffffff;
        color: #1f2937;
        font-family: inherit;
        text-align: right;
        direction: rtl;
        table-layout: fixed;
    }
    .dark .gantt-table {
        background-color: #111827;
        color: #f3f4f6;
    }
    .gantt-table th {
        background-color: #f9fafb !important;
        color: #374151 !important;
        font-weight: 800 !important;
        text-align: center !important;
        padding: 8px 6px !important;
        border: 1px solid #e5e7eb !important;
    }
    .gantt-table th.activity-header {
        text-align: right !important;
        padding-right: 16px !important;
    }
    .dark .gantt-table th {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
        border: 1px solid #374151 !important;
    }
    .gantt-table td {
        padding: 12px 10px !important;
        border: 1px solid #e5e7eb !important;
        vertical-align: middle !important;
        background-color: #ffffff;
    }
    .dark .gantt-table td {
        border: 1px solid #374151 !important;
        background-color: #1f2937 !important;
    }
    .gantt-table tr:hover td {
        background-color: #f9fafb !important;
    }
    .gantt-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .gantt-badge-experiential { background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .gantt-badge-exposure     { background-color: #ecfdf5; color: #047857; border-color: #a7f3d0; }
    .gantt-badge-formal       { background-color: #fffbeb; color: #b45309; border-color: #fde68a; }
    .dark .gantt-badge-experiential { background-color: rgba(30,58,138,.3); color: #60a5fa; border-color: #1e3a8a; }
    .dark .gantt-badge-exposure     { background-color: rgba(6,78,59,.3);  color: #34d399; border-color: #064e3b; }
    .dark .gantt-badge-formal       { background-color: rgba(120,53,4,.3); color: #fbbf24; border-color: #783504; }
    .gantt-active-cell {
        height: 32px;
        width: 100%;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 900;
        color: #ffffff;
    }
    .gantt-active-experiential { background-color: #3b82f6 !important; box-shadow: 0 4px 6px -1px rgba(59,130,246,.2); }
    .gantt-active-exposure     { background-color: #10b981 !important; box-shadow: 0 4px 6px -1px rgba(16,185,129,.2); }
    .gantt-active-formal       { background-color: #f59e0b !important; box-shadow: 0 4px 6px -1px rgba(245,158,11,.2); }
    .gantt-inactive-cell {
        height: 32px;
        width: 100%;
        background-color: #f9fafb;
        border: 1px dashed #e5e7eb;
        border-radius: 6px;
    }
    .dark .gantt-inactive-cell {
        background-color: rgba(31,41,55,.3);
        border: 1px dashed #374151;
    }
    .gantt-year-badge {
        display: inline-block;
        font-size: 9px;
        background-color: #e0e7ff;
        color: #3730a3;
        border-radius: 4px;
        padding: 1px 4px;
        margin-top: 2px;
        font-weight: 700;
    }
    .dark .gantt-year-badge {
        background-color: rgba(67,56,202,.3);
        color: #a5b4fc;
    }
</style>

<div class="space-y-4">
    <div class="gantt-wrapper">
        <table class="gantt-table">
            <thead>
                <tr>
                    <th class="activity-header" style="width: 350px;">النشاط التطويري ومجال النمو</th>
                    <th style="width: 160px;">البند (70-20-10)</th>
                    @foreach ($planSlots as $slot => $info)
                        <th style="width: 55px; text-align: center;">
                            <div style="font-size: 13px; font-weight: 800;">{{ $info['calendar'] }}</div>
                            <div style="font-size: 9px; font-weight: 400; color: #6b7280; margin-top: 1px;">{{ $info['label'] }}</div>
                            @if ($info['year'] > 1)
                                <div class="gantt-year-badge">س{{ $info['year'] }}</div>
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($record->objectives as $obj)
                    @php
                        $badgeClass = match ($obj->learning_type) {
                            'experiential' => 'gantt-badge-experiential',
                            'exposure'     => 'gantt-badge-exposure',
                            'formal'       => 'gantt-badge-formal',
                            default        => '',
                        };
                        $labelText = match ($obj->learning_type) {
                            'experiential' => 'ممارسة عملية (70%)',
                            'exposure'     => 'توجيه واحتكاك (20%)',
                            'formal'       => 'تدريب رسمي (10%)',
                            default        => $obj->learning_type,
                        };
                        $blockClass = match ($obj->learning_type) {
                            'experiential' => 'gantt-active-experiential',
                            'exposure'     => 'gantt-active-exposure',
                            'formal'       => 'gantt-active-formal',
                            default        => 'bg-gray-500',
                        };
                    @endphp
                    <tr>
                        <td style="word-wrap: break-word; white-space: normal;">
                            <div style="font-weight: 700; font-size: 14px; line-height: 1.4; color: #1f2937;" class="dark:text-white">{{ $obj->development_area }}</div>
                            <div style="font-size: 12px; color: #6b7280; margin-top: 6px; line-height: 1.5;" class="dark:text-gray-400">{{ $obj->action_steps }}</div>
                        </td>
                        <td style="text-align: center;">
                            <span class="gantt-badge {{ $badgeClass }}">{{ $labelText }}</span>
                        </td>
                        @foreach ($planSlots as $slot => $info)
                            @php
                                $absVal = $info['abs'];
                                $isActive = false;

                                if ($obj->scheduling_type === 'range') {
                                    // Both start_month and end_month are stored as absolute values
                                    $isActive = ($absVal >= (int)$obj->start_month && $absVal <= (int)$obj->end_month);
                                } elseif ($obj->scheduling_type === 'specific') {
                                    // specific_months contains absolute values
                                    $months = is_array($obj->specific_months) ? $obj->specific_months : [];
                                    $isActive = in_array($absVal, $months);
                                }
                            @endphp
                            <td style="text-align: center;">
                                @if ($isActive)
                                    <div class="gantt-active-cell {{ $blockClass }}"
                                         title="نشط في الشهر {{ $info['calendar'] }} ({{ $info['label'] }})">
                                        ▓
                                    </div>
                                @else
                                    <div class="gantt-inactive-cell"></div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 2 + $planDuration }}" style="text-align: center; padding: 32px; color: #6b7280;">
                            لا توجد أهداف تفصيلية مضافة بعد في هذه الخطة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap items-center gap-6 p-4 rounded-xl bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-400">
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-blue-500 rounded"></div>
            <span>الممارسة والخبرة الميدانية (Experiential Learning - 70%)</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-emerald-500 rounded"></div>
            <span>التوجيه والتعلم الاجتماعي (Exposure &amp; Social Learning - 20%)</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-amber-500 rounded"></div>
            <span>التعليم والتدريب الرسمي (Formal Education - 10%)</span>
        </div>
    </div>
</div>
