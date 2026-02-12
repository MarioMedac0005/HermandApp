<?php

namespace App\Services;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    /**
     * Generar el PDF del contrato y guardar en disco.
     *
     * @param Contract $contract
     * @return string La ruta relativa del PDF
     */
    public function generateContract(Contract $contract): string
    {
        $data = [
            'contract' => $contract,
            'band' => $contract->band,
            'brotherhood' => $contract->brotherhood,
            'procession' => $contract->procession,
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.contract', $data);

        $filename = 'contracts/contract_' . $contract->id . '.pdf';
        $folder = storage_path('app/public/contracts');

        // Crear carpeta si no existe
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $path = $folder . '/contract_' . $contract->id . '.pdf';

        $pdf->save($path);

        return $filename;
    }
}
