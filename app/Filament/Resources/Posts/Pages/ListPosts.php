<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make("generate_pdf")
                ->label("PDF Export")
                ->action(function ($livewire){
                    $records=$livewire->getFilteredTableQuery()->get();

                    $pdf = Pdf::loadView("pdf.posts",["records"=>$records]);

                    return response()->streamDownload(
                        fn() => print($pdf->output()),
                        "posts.pdf"
                    );
                })
        ];
    }
}
