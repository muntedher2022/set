#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$plans = \App\Models\IndividualDevelopmentPlan::with(['objectives', 'user'])->get();
foreach ($plans as $idp) {
    echo "ID={$idp->id} User={$idp->user->name}: {$idp->start_date} => {$idp->end_date} [{$idp->duration_in_months} months]\n";
    foreach ($idp->objectives as $obj) {
        if ($obj->scheduling_type === 'range') {
            echo "   > {$obj->development_area}: range {$obj->start_month} to {$obj->end_month}\n";
        } else {
            echo "   > {$obj->development_area}: specific " . json_encode($obj->specific_months) . "\n";
        }
    }
}
