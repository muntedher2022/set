<x-filament-panels::page>
    <style>
        .nine-box-grid-container {
            width: 100%;
            background-color: #f9fafb;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
        }
        .dark .nine-box-grid-container {
            background-color: rgba(17, 24, 39, 0.4);
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.3);
        }
        .nine-box-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
        }
        .nine-box-row {
            display: flex;
            gap: 16px;
            align-items: stretch;
            width: 100%;
        }
        .nine-box-row-label {
            width: 50px;
            min-width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            border-radius: 8px;
            background-color: #f3f4f6;
            padding: 8px;
        }
        .dark .nine-box-row-label {
            background-color: #1f2937;
            color: #9ca3af;
        }
        .nine-box-cells-container {
            flex: 1;
            display: flex;
            gap: 16px;
        }
        .nine-box-cell {
            flex: 1;
            min-height: 200px;
            padding: 16px;
            border-radius: 12px;
            border-width: 1px;
            border-style: solid;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        .nine-box-cell:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        /* Light Mode Colors */
        .cell-emerald { background-color: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .cell-teal { background-color: #f0fdfa; border-color: #99f6e4; color: #115e59; }
        .cell-sky { background-color: #f0f9ff; border-color: #bae6fd; color: #075985; }
        .cell-indigo { background-color: #e0e7ff; border-color: #c7d2fe; color: #3730a3; }
        .cell-blue { background-color: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .cell-slate { background-color: #f8fafc; border-color: #e2e8f0; color: #334155; }
        .cell-amber { background-color: #fffbeb; border-color: #fde68a; color: #92400e; }
        .cell-orange { background-color: #fff7ed; border-color: #fed7aa; color: #9a3412; }
        .cell-red { background-color: #fef2f2; border-color: #fecaca; color: #991b1b; }

        /* Dark Mode Colors */
        .dark .cell-emerald { background-color: rgba(6, 95, 70, 0.15); border-color: rgba(6, 95, 70, 0.4); color: #34d399; }
        .dark .cell-teal { background-color: rgba(17, 94, 89, 0.15); border-color: rgba(17, 94, 89, 0.4); color: #2dd4bf; }
        .dark .cell-sky { background-color: rgba(7, 89, 133, 0.15); border-color: rgba(7, 89, 133, 0.4); color: #38bdf8; }
        .dark .cell-indigo { background-color: rgba(55, 48, 163, 0.15); border-color: rgba(55, 48, 163, 0.4); color: #818cf8; }
        .dark .cell-blue { background-color: rgba(30, 64, 175, 0.15); border-color: rgba(30, 64, 175, 0.4); color: #60a5fa; }
        .dark .cell-slate { background-color: rgba(51, 65, 85, 0.15); border-color: rgba(51, 65, 85, 0.4); color: #94a3b8; }
        .dark .cell-amber { background-color: rgba(146, 64, 14, 0.15); border-color: rgba(146, 64, 14, 0.4); color: #fbbf24; }
        .dark .cell-orange { background-color: rgba(154, 52, 18, 0.15); border-color: rgba(154, 52, 18, 0.4); color: #fb923c; }
        .dark .cell-red { background-color: rgba(153, 27, 27, 0.15); border-color: rgba(153, 27, 27, 0.4); color: #f87171; }

        .nine-box-col-labels {
            display: flex;
            width: 100%;
            margin-top: 16px;
        }
        .nine-box-col-label-spacer {
            width: 50px;
            min-width: 50px;
            margin-left: 16px; /* spacing between row labels and cell labels */
        }
        [dir="rtl"] .nine-box-col-label-spacer {
            margin-left: 0;
            margin-right: 16px;
        }
        .nine-box-col-label-text {
            flex: 1;
            text-align: center;
            font-weight: bold;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .dark .nine-box-col-label-text {
            color: #9ca3af;
        }
        
        .employee-badge {
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .badge-emerald { background-color: #d1fae5; color: #065f46; }
        .badge-teal { background-color: #ccfbf1; color: #115e59; }
        .badge-sky { background-color: #e0f2fe; color: #075985; }
        .badge-indigo { background-color: #e0e7ff; color: #3730a3; }
        .badge-blue { background-color: #dbeafe; color: #1e40af; }
        .badge-slate { background-color: #f1f5f9; color: #334155; }
        .badge-amber { background-color: #fef3c7; color: #92400e; }
        .badge-orange { background-color: #ffedd5; color: #9a3412; }
        .badge-red { background-color: #fee2e2; color: #991b1b; }

        .dark .badge-emerald { background-color: rgba(52, 211, 153, 0.2); color: #34d399; }
        .dark .badge-teal { background-color: rgba(45, 212, 191, 0.2); color: #2dd4bf; }
        .dark .badge-sky { background-color: rgba(56, 189, 248, 0.2); color: #38bdf8; }
        .dark .badge-indigo { background-color: rgba(129, 140, 248, 0.2); color: #818cf8; }
        .dark .badge-blue { background-color: rgba(96, 165, 250, 0.2); color: #60a5fa; }
        .dark .badge-slate { background-color: rgba(148, 163, 184, 0.2); color: #94a3b8; }
        .dark .badge-amber { background-color: rgba(251, 191, 36, 0.2); color: #fbbf24; }
        .dark .badge-orange { background-color: rgba(251, 146, 60, 0.2); color: #fb923c; }
        .dark .badge-red { background-color: rgba(248, 113, 113, 0.2); color: #f87171; }
    </style>

    <div class="space-y-6">
        <!-- مقدمة توضيحية للمصفوفة -->
        <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">كيف تعمل مصفوفة المربعات التسعة (9-Box Grid)؟</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                تقوم هذه المصفوفة بمعايرة الكوادر البشرية وتحديد مواقعهم الإستراتيجية عبر تقاطع محورين رئيسيين: 
                <strong class="text-primary-600 dark:text-primary-400">الأداء الفعلي المحقق (من واقع الـ KPIs)</strong> على المحور العمودي، 
                و<strong class="text-primary-600 dark:text-primary-400">إمكانات النمو والتطوير (من واقع خطط الـ IDPs)</strong> على المحور الأفقي. 
                يساعد هذا التوزيع القادة على اتخاذ قرارات ترقية عادلة، توطين المعرفة، أو التدخل السريع بخطط تصحيح المسار (PIP).
            </p>
        </div>

        <!-- الهيكل الرئيسي للمصفوفة -->
        <div class="nine-box-grid-container">
            <div class="nine-box-grid">
                
                @php
                    $rows = [
                        'high_performance' => [
                            'label' => 'أداء مرتفع (≥ 115%)',
                            'cols' => ['low_potential', 'medium_potential', 'high_potential']
                        ],
                        'medium_performance' => [
                            'label' => 'أداء متوسط (80% - 114%)',
                            'cols' => ['low_potential', 'medium_potential', 'high_potential']
                        ],
                        'low_performance' => [
                            'label' => 'أداء منخفض (< 80%)',
                            'cols' => ['low_potential', 'medium_potential', 'high_potential']
                        ]
                    ];

                    $colorMap = [
                        'high_performance' => [
                            'low_potential' => ['class' => 'cell-sky', 'badge' => 'badge-sky'],
                            'medium_potential' => ['class' => 'cell-teal', 'badge' => 'badge-teal'],
                            'high_potential' => ['class' => 'cell-emerald', 'badge' => 'badge-emerald'],
                        ],
                        'medium_performance' => [
                            'low_potential' => ['class' => 'cell-slate', 'badge' => 'badge-slate'],
                            'medium_potential' => ['class' => 'cell-blue', 'badge' => 'badge-blue'],
                            'high_potential' => ['class' => 'cell-indigo', 'badge' => 'badge-indigo'],
                        ],
                        'low_performance' => [
                            'low_potential' => ['class' => 'cell-red', 'badge' => 'badge-red'],
                            'medium_potential' => ['class' => 'cell-orange', 'badge' => 'badge-orange'],
                            'high_potential' => ['class' => 'cell-amber', 'badge' => 'badge-amber'],
                        ]
                    ];
                @endphp

                @foreach ($rows as $rowKey => $rowData)
                    <div class="nine-box-row">
                        <!-- تسمية محور الأداء لكل صف -->
                        <div class="nine-box-row-label">
                            {{ $rowData['label'] }}
                        </div>

                        <!-- خلايا الصف الثلاثة -->
                        <div class="nine-box-cells-container">
                            @foreach ($rowData['cols'] as $colKey)
                                @php
                                    $box = $grid[$rowKey][$colKey];
                                    $theme = $colorMap[$rowKey][$colKey];
                                @endphp
                                <div class="nine-box-cell {{ $theme['class'] }}">
                                    <!-- عنوان المربع ووصفه -->
                                    <div class="mb-3">
                                        <h3 class="font-bold text-sm leading-tight mb-1">{{ $box['title'] }}</h3>
                                        <p class="text-[11px] opacity-75 leading-tight">{{ $box['description'] }}</p>
                                    </div>

                                    <!-- قائمة الموظفين في هذا المربع -->
                                    <div class="flex-1 space-y-2 overflow-y-auto max-h-[140px] pr-1">
                                        @forelse ($box['employees'] as $emp)
                                            <a href="{{ \App\Filament\Resources\Users\UserResource::getUrl('edit', ['record' => $emp['id']]) }}" 
                                               class="block p-2 rounded-lg bg-white/80 hover:bg-white dark:bg-gray-900/60 dark:hover:bg-gray-900 border border-black/5 hover:border-black/10 dark:border-white/5 dark:hover:border-white/10 transition-all shadow-sm">
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $emp['name'] }}</span>
                                                    <span class="employee-badge {{ $theme['badge'] }}">
                                                        {{ $emp['avg_kpi'] }}%
                                                    </span>
                                                </div>
                                                @if($emp['idp_goal'])
                                                    <div class="text-[10px] mt-1 text-gray-500 dark:text-gray-400 truncate">
                                                        🎯 {{ $emp['idp_goal'] }}
                                                    </div>
                                                @endif
                                            </a>
                                        @empty
                                            <div class="h-full flex items-center justify-center border border-dashed border-black/10 dark:border-white/10 rounded-lg py-4">
                                                <span class="text-[10px] text-gray-400 dark:text-gray-500">لا يوجد موظفون حالياً</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- محور الأفق (إمكانات النمو Potential) -->
                <div class="nine-box-col-labels">
                    <div class="nine-box-col-label-spacer"></div>
                    <div class="nine-box-col-label-text">منخفض النمو / لا توجد خطط IDP</div>
                    <div class="nine-box-col-label-text">متوسط النمو / خطة IDP نشطة</div>
                    <div class="nine-box-col-label-text">مرتفع النمو / خطة IDP مكتملة</div>
                </div>

                <!-- العنوان الرئيسي للمحور الأفقي -->
                <div class="text-center font-bold text-base text-gray-700 dark:text-gray-300 mt-4 border-t border-gray-200 dark:border-gray-800 pt-4">
                    &larr; إمكانيات النمو والتطوير (IDP) &larr;
                </div>

            </div>
        </div>
    </div>
</x-filament-panels::page>
