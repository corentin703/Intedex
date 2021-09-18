<?php

namespace App\Exports;

use App\Http\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class UsersExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithEvents
{
    use Exportable;

    /**
     * Optional Writer Type
     */
    private string $writerType = Excel::XLSX;

    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Intedex',
            'lastModifiedBy' => 'Intedex',
            'title'          => 'Users export - ' . Date::now()->format("yyyy-mm-dd"),
            'description'    => 'Users exported at ' . Date::now()->format("yyyy-mm-dd - h:mm"),
            'subject'        => 'Users',
            'keywords'       => 'intedex,users',
            'category'       => 'Users',
            'manager'        => 'Intedex',
            'company'        => 'BDE ISIMA',
        ];
    }

    public function collection(): Collection
    {
        return $this->userRepository->getAll();
    }

//    public function query(): Collection
//    {
//        return $this->userRepository->getAll();
//    }

    public function map($user): array
    {
        $pokemon_count = $user->pokemons->count();
        $score = $user->getScore();

        return [
                $user->id,
                $user->name,
                $user->email,
                $user->created_at,
                $pokemon_count == 0 ? "0" : $pokemon_count,
                $score == 0 ? "0" : $score,
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Email',
            'Signed up at',
            'Pokemon caught',
            'Score',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'D' => 'dd/mm/yyyy h:mm',
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $activeSheet = $event->sheet->getDelegate();
                $activeSheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                $activeSheet->setAutoFilter(
                    $activeSheet->calculateWorksheetDimension()
                );

                foreach ($activeSheet->getColumnIterator() as $col) {
                    $activeSheet->getColumnDimension($col->getColumnIndex())->setWidth(30);
                }
            },
        ];
    }
}
