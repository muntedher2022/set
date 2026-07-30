<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SwotAnalysis;
use App\Models\GoalAndKpi;
use App\Models\CriticalIncidentLog;
use App\Models\GrowSession;
use App\Models\IndividualDevelopmentPlan;
use App\Models\IdpObjective;
use App\Models\PerformanceImprovementPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'name' => 'مدير النظام الرئيسي',
            'email' => 'admin@apes.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Coach/Manager
        $coach = User::create([
            'name' => 'الكوتش أحمد علي',
            'email' => 'coach@apes.com',
            'password' => Hash::make('password'),
            'role' => 'coach',
            'manager_id' => $admin->id,
        ]);

        // 3. Create the 9 Employees to cover all 9 boxes of the 9-Box Grid
        $emp1 = User::create([
            'name' => 'منتظر محمد عبيد (Low-Low)',
            'email' => 'employee1@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp2 = User::create([
            'name' => 'نهاد جبر عبود (High-Medium)',
            'email' => 'employee2@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp3 = User::create([
            'name' => 'ماجد صالح مهدي (Medium-Medium)',
            'email' => 'employee3@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp4 = User::create([
            'name' => 'ياس خضر سالم (High-High)',
            'email' => 'employee4@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp5 = User::create([
            'name' => 'طارق عبدالرضا هالد (High-Low)',
            'email' => 'employee5@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp6 = User::create([
            'name' => 'احمد حسين درويش (Medium-Low)',
            'email' => 'employee6@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp7 = User::create([
            'name' => 'ضياء محسن مغامس (Medium-High)',
            'email' => 'employee7@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp8 = User::create([
            'name' => 'احمد حسن خلف (Low-Medium)',
            'email' => 'employee8@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        $emp9 = User::create([
            'name' => 'فراس صالح مهدي (Low-High)',
            'email' => 'employee9@apes.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'manager_id' => $coach->id,
        ]);

        // --- SWOT Analysis Seeding ---
        SwotAnalysis::create([
            'scope' => 'institutional',
            'type' => 'strength',
            'title' => 'البنية التحتية البرمجية المتطورة',
            'description' => 'تمتلك المنظمة بنية تحتية سحابية مرنة تمكنها من التوسع الرقمي بسرعة.',
        ]);

        SwotAnalysis::create([
            'scope' => 'institutional',
            'type' => 'weakness',
            'title' => 'فجوة المهارات في واجهات الإدارة الحديثة',
            'description' => 'وجود بعض النقص في مهارات التطوير باستخدام حزم Filament PHP لدى فرق التطوير.',
        ]);

        // --- Goals and KPIs (BSC) ---
        $employees = [$emp1, $emp2, $emp3, $emp4, $emp5, $emp6, $emp7, $emp8, $emp9];
        
        // Progress matrix: 4 goals for each employee (each weight 25% to sum to 100%)
        // We define the target progress rates for each of the 9 employees
        $progressRates = [
            $emp1->id => [0.00, 20.00, 0.00, 40.00],      // Avg = 15.00% (Low Performance)
            $emp2->id => [110.00, 125.00, 120.00, 115.00], // Avg = 117.5% (High Performance)
            $emp3->id => [90.00, 100.00, 95.00, 95.00],    // Avg = 95.00% (Medium Performance)
            $emp4->id => [120.00, 120.00, 120.00, 120.00], // Avg = 120.00% (High Performance)
            $emp5->id => [115.00, 120.00, 118.00, 119.00], // Avg = 118.00% (High Performance)
            $emp6->id => [95.00, 98.00, 95.00, 96.00],     // Avg = 96.00% (Medium Performance)
            $emp7->id => [96.00, 100.00, 98.00, 98.00],    // Avg = 98.00% (Medium Performance)
            $emp8->id => [50.00, 60.00, 55.00, 67.00],     // Avg = 58.00% (Low Performance)
            $emp9->id => [50.00, 70.00, 60.00, 60.00],     // Avg = 60.00% (Low Performance)
        ];

        $perspectives = ['learning_growth', 'internal_processes', 'customer', 'financial_strategic'];
        $titles = [
            'learning_growth' => 'حضور الدورات التدريبية واكتساب مهارات Filament',
            'internal_processes' => 'تقليص نسبة الأخطاء البرمجية بعد الإطلاق الفعلي',
            'customer' => 'معالجة الشكاوى البرمجية المرفوعة بنسبة رضا متفوقة',
            'financial_strategic' => 'تطوير أدوات الأتمتة لتقليل الجهد المالي البشري',
        ];

        foreach ($employees as $emp) {
            if ($emp->id === $emp2->id) {
                // Seed custom Berth Observer goals for Rana Elyasien
                GoalAndKpi::create([
                    'user_id' => $emp->id,
                    'perspective' => 'learning_growth',
                    'smart_goal_text' => 'تطوير المهارات الرقمية للكادر الفني وملاحظي الرصيف بميناء أم قصر الشمالي',
                    'weight' => 20.00,
                    'baseline' => 600.00,
                    'target' => 850.00,
                    'current_progress_rate' => 110.00, // 110% achievement
                    'kpi_type' => 'leading',
                ]);
                GoalAndKpi::create([
                    'user_id' => $emp->id,
                    'perspective' => 'internal_processes',
                    'smart_goal_text' => 'تقليص متوسط زمن بقاء السفينة على الرصيف لتعزيز الطاقة التشغيلية للميناء',
                    'weight' => 30.00,
                    'baseline' => 48.00,
                    'target' => 40.00,
                    'current_progress_rate' => 125.00, // 125% achievement
                    'kpi_type' => 'lagging',
                ]);
                GoalAndKpi::create([
                    'user_id' => $emp->id,
                    'perspective' => 'customer',
                    'smart_goal_text' => 'رفع مؤشر رضا الخطوط الملاحية عن كفاءة إجراءات الرصيف والخدمات المصاحبة',
                    'weight' => 20.00,
                    'baseline' => 5.00,
                    'target' => 9.00,
                    'current_progress_rate' => 120.00, // 120% achievement
                    'kpi_type' => 'leading',
                ]);
                GoalAndKpi::create([
                    'user_id' => $emp->id,
                    'perspective' => 'financial_strategic',
                    'smart_goal_text' => 'تعزيز السلامة المهنية والحد من الحوادث ورفع نسبة جاهزية المعدات الرصيفية',
                    'weight' => 30.00,
                    'baseline' => 85.00,
                    'target' => 95.00,
                    'current_progress_rate' => 115.00, // 115% achievement
                    'kpi_type' => 'lagging',
                ]);
            } else {
                $rates = $progressRates[$emp->id];
                foreach ($perspectives as $index => $pers) {
                    GoalAndKpi::create([
                        'user_id' => $emp->id,
                        'perspective' => $pers,
                        'smart_goal_text' => $titles[$pers] . ' الخاص بالموظف ' . $emp->name,
                        'weight' => 25.00,
                        'baseline' => $pers === 'internal_processes' ? 6.00 : 0.00,
                        'target' => $pers === 'internal_processes' ? 1.00 : 2.00,
                        'current_progress_rate' => $rates[$index],
                        'kpi_type' => $index % 2 === 0 ? 'leading' : 'lagging',
                    ]);
                }
            }
        }

        // --- IDPs (Individual Development Plans) to determine Potential (X-Axis) ---
        // Active IDPs => Medium Potential
        // IDP2: fixed dates so month values remain consistent with seeded objectives
        // Plan: May 1 2026 -> Oct 31 2026 = 6 months. abs months: May=5, Jun=6, Jul=7, Aug=8, Sep=9, Oct=10
        $idp2 = IndividualDevelopmentPlan::create([
            'user_id' => $emp2->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'تأهيل نهاد جبر عبود لتولي منصب معاون مدير قسم تشغيل الأرصفة البحرية بميناء أم قصر.',
            'start_date' => '2026-05-01',
            'end_date'   => '2026-10-31',
            'status' => 'active',
        ]);
        $idp3 = IndividualDevelopmentPlan::create([
            'user_id' => $emp3->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'تأهيل ماجد صالح مهدي لتولي منصب مشرف العمليات التقنية بالقسم.',
            'start_date' => now()->subMonths(1),
            'end_date' => now()->addMonths(5),
            'status' => 'active',
        ]);
        $idp8 = IndividualDevelopmentPlan::create([
            'user_id' => $emp8->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'خطة نمو تمكينية لدعم الموظف الجديد في فهم النظام.',
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        // Completed IDPs => High Potential
        // IDP4: fixed dates for 18-month plan. Start = Jul 2025, End = Jan 2027
        // abs months: slot1=Jul=7, slot2=Aug=8 ... slot6=Dec=12, slot7=Jan=13, slot8=Feb=14 ... slot18=Dec=24
        $idp4 = IndividualDevelopmentPlan::create([
            'user_id' => $emp4->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'برنامج إعداد قيادات الصف الأول لتولي إدارة التقنية بالكامل (خطة 18 شهراً).',
            'start_date' => '2025-07-01',
            'end_date'   => '2027-01-01',
            'status' => 'active',
        ]);

        // Seed 18-month objectives for idp4 to test scaling
        IdpObjective::create([
            'idp_id' => $idp4->id,
            'development_area' => 'التخطيط الاستراتيجي وإدارة المشاريع التقنية الكبرى',
            'learning_type' => 'experiential',
            'scheduling_type' => 'range',
            'start_month' => 7,
            'end_month' => 12,
            'action_steps' => 'إدارة دورة حياة تطوير الأنظمة والبرمجيات بالميناء بالكامل لـ 15 شهراً وتطبيق معايير CMMI.',
            'measure_of_success' => 'تسليم نظام الميناء الموحد بنجاح دون تأخير تشغيلي.',
            'support_needed' => 'تخصيص مستشار فني خارجي للمرافقة والمشورة الفنية.',
            'status' => 'in_progress',
        ]);
        IdpObjective::create([
            'idp_id' => $idp4->id,
            'development_area' => 'المعايشة القيادية وتوجيه الصف الأول',
            'learning_type' => 'exposure',
            'scheduling_type' => 'specific',
            'specific_months' => [8, 12, 16],
            'action_steps' => 'معايشة مدير إدارة تكنولوجيا المعلومات وحضور اجتماعات اللجنة القيادية كل 4 أشهر.',
            'measure_of_success' => 'إتمام 4 فترات معايشة قيادية بنجاح.',
            'support_needed' => 'تنسيق جدول الاجتماعات القيادية.',
            'status' => 'in_progress',
        ]);
        IdpObjective::create([
            'idp_id' => $idp4->id,
            'development_area' => 'البرنامج القيادي الدولي لقطاع الاتصالات والموانئ',
            'learning_type' => 'formal',
            'scheduling_type' => 'range',
            'start_month' => 10,
            'end_month' => 13,
            'action_steps' => 'الحصول على شهادة مهنية متقدمة في قيادة التحول الرقمي بالمؤسسات البحرية.',
            'measure_of_success' => 'الحصول على الشهادة القيادية الدولية بنجاح.',
            'support_needed' => 'تغطية تكاليف ورسوم الاشتراك والشهادة بالكامل.',
            'status' => 'completed',
        ]);

        $idp7 = IndividualDevelopmentPlan::create([
            'user_id' => $emp7->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'تنمية المهارات الإدارية المتقدمة لتمكينه من قيادة المبيعات.',
            'start_date' => now()->subMonths(4),
            'end_date' => now()->subMonths(2),
            'status' => 'completed',
        ]);
        $idp9 = IndividualDevelopmentPlan::create([
            'user_id' => $emp9->id,
            'mentor_id' => $coach->id,
            'career_goal' => 'إعادة تموضع وتوجيه المهارات لقسم أكثر ملاءمة.',
            'start_date' => now()->subMonths(3),
            'end_date' => now()->subMonth(),
            'status' => 'completed',
        ]);

        // IDP2 objectives - abs months from plan start (May=5):
        // slot1=5(May), slot2=6(Jun), slot3=7(Jul), slot4=8(Aug), slot5=9(Sep), slot6=10(Oct)
        IdpObjective::create([
            'idp_id' => $idp2->id,
            'development_area' => 'قيادة مشروع التحول الرقمي وأتمتة الأرصفة',
            'learning_type' => 'experiential',
            'scheduling_type' => 'range',
            'start_month' => 5,   // May  (slot1)
            'end_month'   => 8,   // Aug  (slot4)
            'action_steps' => 'تعيينها كرئيسة لفريق مشروع "أتمتة المعاملات الورقية وحجز الأرصفة" لتطوير مهاراتها في الإدارة الفنية وحل المشكلات.',
            'measure_of_success' => 'أتمتة 100% من المعاملات الورقية بالرصيف بنجاح.',
            'support_needed' => 'توفير الميزانية وجهاز حاسوب محمول حديث، وتفويض الصلاحيات الفنية.',
            'status' => 'completed',
        ]);
        IdpObjective::create([
            'idp_id' => $idp2->id,
            'development_area' => 'الإنابة الإدارية وإدارة الاجتماعات',
            'learning_type' => 'experiential',
            'scheduling_type' => 'range',
            'start_month' => 7,   // Jul  (slot3)
            'end_month'   => 10,  // Oct  (slot6)
            'action_steps' => 'تكليفها رسمياً بمهام "معاون مدير قسم الأرصفة" وتفويضها لإدارة الاجتماعات الدورية واتخاذ القرارات التشغيلية في فترات غياب المدير.',
            'measure_of_success' => 'إدارة 5 اجتماعات دورية على الأقل واتخاذ القرارات دون أخطاء تشغيلية.',
            'support_needed' => 'إصدار أمر تكليف رسمي ودعم إداري من مدير القسم.',
            'status' => 'completed',
        ]);
        IdpObjective::create([
            'idp_id' => $idp2->id,
            'development_area' => 'المرافقة القيادية ومعايشة القادة',
            'learning_type' => 'exposure',
            'scheduling_type' => 'specific',
            'specific_months' => [6, 8, 10],  // Jun(slot2), Aug(slot4), Oct(slot6)
            'action_steps' => 'تخصيص فترات معايشة بمعدل 3 أيام كل شهر لمرافقة مدير عام الموانئ.',
            'measure_of_success' => 'إتمام فترات المعايشة وحضور 6 اجتماعات استراتيجية على الأقل.',
            'support_needed' => 'تنسيق المواعيد مع مكتب المدير العام وتسهيل الدخول.',
            'status' => 'in_progress',
        ]);
        IdpObjective::create([
            'idp_id' => $idp2->id,
            'development_area' => 'البرنامج القيادي المتقدم لقطاع الموانئ',
            'learning_type' => 'formal',
            'scheduling_type' => 'range',
            'start_month' => 5,   // May  (slot1)
            'end_month'   => 7,   // Jul  (slot3)
            'action_steps' => 'إشراكها في دبلوم مصغر حول "الإدارة الاستراتيجية والتفكير القيادي في تشغيل الموانئ البحرية".',
            'measure_of_success' => 'الحصول على شهادة الدبلوم القيادي بتقدير ممتاز.',
            'support_needed' => 'دفع رسوم الدبلوم بالكامل من قبل المؤسسة وتوفير التفرغ.',
            'status' => 'completed',
        ]);

        // --- Performance Improvement Plans (PIP) ---
        // Emp 1 has an active PIP
        PerformanceImprovementPlan::create([
            'user_id' => $emp1->id,
            'gap_description' => 'تراجع الأداء الفني والبرمجي بشكل كبير (KPI 15%) وتكرار الأخطاء البرمجية الفادحة دون اختبار، بالإضافة لتكرار سلوكيات حادة مع الزملاء.',
            'strict_targets' => 'الالتزام التام بعدم رفع أي تحديثات غير مختبرة، تسليم كافة المهام في الموعد المحدد بنسبة 100%، والالتزام بأدبيات التواصل الاحترافي.',
            'management_support' => 'تخصيص كوتش للمراجعة الثنائية للكود قبل الرفع، وجلسة توجيه GROW يومية لمدة 15 دقيقة لقياس التقدم وتخفيف التوتر.',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25), // 30-day PIP
            'status' => 'active',
            'employee_signed' => true,
            'manager_signed' => true,
        ]);

        // --- Critical Incident Logs (SBI Model) ---
        CriticalIncidentLog::create([
            'user_id' => $emp1->id,
            'reporter_id' => $coach->id,
            'incident_date' => now()->subDays(10),
            'type' => 'negative',
            'observed_situation' => 'أثناء اجتماع تسليم مشروع البوابة الإلكترونية يوم الثلاثاء الماضي.',
            'actual_behavior' => 'تأخر الموظف عن تسليم الكود البرمجي لمدة 3 أيام دون إبداء أسباب أو تقديم اعتذار مسبق للمشرف.',
            'result_impact' => 'أدى ذلك إلى تأجيل موعد الإطلاق التجريبي للبوابة وتأثر رضا العميل بشكل سلبي.',
        ]);

        CriticalIncidentLog::create([
            'user_id' => $emp2->id,
            'reporter_id' => $coach->id,
            'incident_date' => now()->subDays(15),
            'type' => 'positive',
            'observed_situation' => 'عند تعطل خادم قاعدة البيانات الرئيسي بشكل مفاجئ الساعة 10 ليلاً.',
            'actual_behavior' => 'تدخلت الموظفة طواعية وعملت على حل المشكلة واستعادة البيانات الاحتياطية وإعادة الخادم للخدمة.',
            'result_impact' => 'منع هذا التدخل فقدان البيانات التشغيلية الهامة وضمن استمرار العمل دون توقف في اليوم التالي.',
        ]);

        // --- GROW Coaching Sessions ---
        GrowSession::create([
            'user_id' => $emp3->id,
            'coach_id' => $coach->id,
            'session_date' => now()->subDays(5),
            'goal' => 'رفع نسبة الالتزام بتسليم التقارير الفنية الأسبوعية لتصبح 100%.',
            'reality' => 'نسبة الالتزام الحالية هي 95% بسبب التشتت بين مهام تطويرية متعددة وضيق الوقت نهاية الأسبوع.',
            'options' => 'جدولة ساعتين صباح كل خميس لإعداد التقارير فقط، تفويض بعض المهام البرمجية البسيطة للزملاء الجدد.',
            'way_forward' => 'تخصيص وقت الخميس لإعداد التقارير، والبدء بتطبيق التفويض الفوري للمهام البسيطة من الغد، مع المراجعة الخميس القادم.',
        ]);
    }
}
