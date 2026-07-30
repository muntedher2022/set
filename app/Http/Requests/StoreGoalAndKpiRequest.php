<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreGoalAndKpiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'perspective' => 'required|in:learning_growth,internal_processes,customer,financial_strategic',
            'smart_goal_text' => 'required|string|min:15',
            'weight' => 'required|numeric|min:10|max:30', // حد أدنى 10% وحد أقصى 30% لضمان التوازن والتركيز
            'baseline' => 'required|numeric|min:0',
            'target' => 'required|numeric|different:baseline', // هدف متمدد مختلف عن خط الأساس (يمكن أن يكون أصغر في مؤشرات تقليل الأخطاء/التكاليف)
            'kpi_type' => 'required|in:leading,lagging',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userId = $this->input('user_id');
            $newWeight = $this->input('weight');
            $goalId = $this->route('goal') ? $this->route('goal')->id : $this->input('id'); // Support both API and form inputs

            $currentTotalWeight = DB::table('goals_and_kpis')
                ->where('user_id', $userId)
                ->when($goalId, function ($query) use ($goalId) {
                    return $query->where('id', '!=', $goalId);
                })
                ->sum('weight');

            if ($currentTotalWeight + $newWeight > 100.00) {
                $validator->errors()->add(
                    'weight', 
                    "مجموع الأوزان الحالية للموظف هو {$currentTotalWeight}%. إضافة هذا الهدف بوزن {$newWeight}% يتجاوز الحد الأقصى الرياضي المسموح به (100%)!"
                );
            }
        });
    }
}
