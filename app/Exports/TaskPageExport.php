<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TaskPageExport implements FromView
{
    public $tasks;
    private $sheetTitle;

    public function __construct($tasks = [], $sheetTitle)
    {
        $this->tasks= $tasks ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {


        return view('export.tasks', [
            'items' => $this->tasks,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
