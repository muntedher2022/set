# 📋 وثيقة سياق المشروع (CONTEXT.md)

## 📌 نبذة عن المشروع
* **الاسم:** نظام تقييم الأداء والتطوير الفردي (APES - Employee Development & Evaluation).
* **الهدف:** منصة متقدمة لتخطيط وتطوير الموارد البشرية، قياس مؤشرات الأداء، جلسات التوجيه المهني، ومعالجة القصور الوظيفي.

## ✅ ما تم إنجازه حتى الآن
* **خطط التطوير الفردي (IDP):** صياغة أهداف التطوير (IDP Objectives) وجداول تحسين كفاءة الموظف.
* **مؤشرات الأداء والأهداف (Goals & KPIs):** قياس دقيق للمخرجات ومستويات الإنجاز الفردية والمؤسسية.
* **جلسات التوجيه بنموذج GROW:** توثيق جلسات التدريب والإرشاد بين المدربين والموظفين.
* **خطط تحسين الأداء (PIP):** إدارة برامج معالجة جوانب القصور ومتابعة نتائجها وإجراءاتها التصحيحية.
* **سجل الوقائع الحرجة (Critical Incident Log):** توثيق السلوكيات والمواقف المميزة أو السلبية بالتواريخ والشهادات.
* **تحليل SWOT المهني:** تحليل نقاط القوة، الضعف، الفرص، والتحديات للكادر الوظيفي مع تأمين الحسابات عبر TOTP 2FA.

## 🛠️ التقنيات المستخدمة
* **Backend:** Laravel 11 (PHP 8.2+)
* **Admin Panel:** Filament Admin v3/v5
* **Database:** MySQL / SQLite
* **Packages:** Google2FA, Bacon QR

## 📂 هيكل الملفات الأساسية
* `app/Models/`: (IndividualDevelopmentPlan, IdpObjective, GoalAndKpi, GrowSession, PerformanceImprovementPlan, CriticalIncidentLog, SwotAnalysis, User).
* `app/Filament/Resources/`: موارد الإدارة (IndividualDevelopmentPlans, GoalAndKpis, GrowSessions, PerformanceImprovementPlans, CriticalIncidentLogs, SwotAnalyses, Users).
* `database/migrations/`: جداول خطط التطوير، مؤشرات الأداء، جلسات النمو، والوقائع الحرجة.
* `docs/`: أدلة مسار العمل والنماذج الإدارية (apes_workflow_guide.md, system_dependency_diagram.md).
