
@php
    use App\Components\Helper;
    use App\Constants\InstansiConstant;
@endphp

<div class="row">

    <div class="col-md-5">
        <div class="card card-default">
            <div class="card-header"><h3 class="card-title">Chart Nilai Perangkat Daerah</h3></div>
            <div class="card-body">
                <canvas id="chartNilaiPenilaian"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-default">
            <div class="card-header"><h3 class="card-title">Top 10 Nilai Perangkat Daerah</h3></div>
            <div class="card-body">
                <div style="overflow:auto;">
                    <table class="table table-bordered mb-0 table-sm">
                        <thead>
                            <tr>
                                <th style="width:60px;text-align:center">No</th>
                                <th>Perangkat Daerah</th>
                                <th style="width:100px;text-align:right">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allInstansiNilaiPenilaianTertinggi as $instansi)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $instansi->nama }}</td>
                                    <td class="text-right">
                                        {{ Helper::rp($instansi->kuesionerResponden?->nilai_penilaian, 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route(InstansiConstant::RouteIndexPenilaian) }}">Lihat Selengkapnya...</a>      
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const labels = @json($distribusiNilaiPenilaian['labels']);
    const data   = @json($distribusiNilaiPenilaian['values']);

    const ctx = document.getElementById('chartNilaiPenilaian').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: [
                    '#ef4444',
                    '#f97316',
                    '#f59e0b',
                    '#fde047',
                    '#84cc16',
                    '#22c55e',
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.label}: ${ctx.parsed} perangkat daerah`
                    }
                }
            }
        }
    });
})();
</script>
@endpush

