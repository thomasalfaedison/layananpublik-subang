<?php

namespace App\Console\Commands;

use App\Models\KuesionerPertanyaan;
use App\Models\KuesionerPertanyaanPenilaian;
use App\Models\KuesionerPertanyaanPilihan;
use Illuminate\Console\Command;

class SyncKuesionerPertanyaanPenilaian extends Command
{
    /**
     * The name and signature of the console command.
     * Default kode is F-02; add --dry-run to preview.
     */
    protected $signature = 'kuesioner:sync-penilaian {--dry-run}';

    /**
     * The console command description.
     */
    protected $description = 'Create/Update kuesioner_pertanyaan_penilaian from kuesioner_pertanyaan_pilihan (filter by kuesioner.kode). Exists check by id_kuesioner_pertanyaan + nilai (urutan).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $kode = 'F-02';
        $dryRun = (bool) $this->option('dry-run');

        $this->info("Sync penilaian kode={$kode}" . ($dryRun ? ' [DRY RUN]' : ''));

        $totalPilihan = 0;
        $totalUpdated = 0;
        $totalCreated = 0;

        KuesionerPertanyaanPilihan::query()
            ->whereHas('kuesionerPertanyaan.kuesioner', function ($q) use ($kode) {
                $q->where('kode', $kode);
            })
            ->orderBy('id')
            ->chunkById(500, function ($chunk) use (&$totalPilihan, &$totalUpdated, &$totalCreated, $dryRun) {
                foreach ($chunk as $pilihan) {
                    $totalPilihan++;

                    $id_penilaian_indikator = $pilihan->kuesionerPertanyaan->id_penilaian_indikator;
                    $nama = $pilihan->nama;
                    $nilai  = $pilihan->urutan;

                    $refKuesionerPertanyaan = KuesionerPertanyaan::query()
                        ->where('id_kuesioner', '=', $pilihan->kuesionerPertanyaan->kuesioner->id_kuesioner_mandiri)
                        ->where('id_penilaian_indikator', '=', $id_penilaian_indikator)
                        ->first();
                        
                    if ($refKuesionerPertanyaan == null) {
                        continue;
                    }

                    $id_kuesioner_pertanyaan = $refKuesionerPertanyaan->id;

                    $penilaian = KuesionerPertanyaanPenilaian::query()
                        ->where('id_kuesioner_pertanyaan', $id_kuesioner_pertanyaan)
                        ->where('nilai', $nilai)
                        ->first();

                    if ($penilaian) {
                        if (!$dryRun) {
                            $penilaian->update([
                                'id_kuesioner_pertanyaan' => $id_kuesioner_pertanyaan,
                                'nama' => $nama,
                                'nilai' => (int) $nilai,
                            ]);
                        }
                        $totalUpdated++;
                    } else {
                        if (!$dryRun) {
                            KuesionerPertanyaanPenilaian::create([
                                'id_kuesioner_pertanyaan' => $id_kuesioner_pertanyaan,
                                'nama' => $nama,
                                'nilai' => (int) $nilai,
                            ]);
                        }
                        $totalCreated++;
                    }
                }
            });

        $suffix = $dryRun ? ' (dry-run)' : '';
        $this->info("Processed: {$totalPilihan} | Updated: {$totalUpdated} | Created: {$totalCreated}{$suffix}");

        return self::SUCCESS;
    }
}
