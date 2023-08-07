<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\BarChartWidget;

class TransactionChart2 extends BarChartWidget
{
    protected static ?string $heading = 'Transaction Remarks Count';
    protected static ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $remarks = ['Closed', 'Processing', 'Cancelled'];
        $counts = [];

        foreach ($remarks as $remark) {
            $count = Transaction::where('remarks', $remark)->count();
            $counts[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transaction Remarks',
                    'data' => $counts,
                    'backgroundColor' => ['#00FF00', '#36A2EB', '#FFCE56'], // Set colors for each bar
                ],
            ],
            'labels' => $remarks,
        ];
    }
}
