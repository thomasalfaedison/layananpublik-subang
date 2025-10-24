<?php

namespace App\Console\Commands;

use App\Constants\KuesionerConstant;
use App\Models\KuesionerResponden;
use App\Services\KuesionerJawabanService;
use Illuminate\Console\Command;

class UpdateProgresPenilaian extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'kuesioner:update-progres-penilaian';

    /**
     * The console command description.
     */
    protected $description = 'Hitung ulang progres penilaian untuk semua responden selain kuesioner F-01 (kode != F-01).';

    /**
     * Execute the console command.
     */
    public function handle(KuesionerJawabanService $service): int
    {
        $this->info("Update progres penilaian untuk semua responden yang memiliki penilaian");

        $processed = 0;

        KuesionerResponden::query()
            ->whereHas('manyKuesionerRespondenPenilaian')
            ->orderBy('id')
            ->chunkById(500, function ($chunk) use (&$processed, $service) {
                foreach ($chunk as $responden) {
                    $processed++;
                    $service->updateProgresPenilaian($responden);
                }
            });

        $this->info("Total responden diproses: {$processed}");

        return self::SUCCESS;
    }
}
