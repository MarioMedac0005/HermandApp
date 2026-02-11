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

        // Cargar la vista Blade y generar el PDF
        $pdf = Pdf::loadView('pdf.contract', $data);

        // Definir nombre y ruta dentro de storage/app/public/contracts/
        $filename = 'contracts/contract_' . $contract->id . '.pdf';
        $path = storage_path('app/public/' . $filename);

        // Guardar el PDF en disco
        $pdf->save($path);

        // Devolver la ruta relativa para guardarla en la base de datos
        return $filename;
    }
}
