@php
    use App\Components\Helper;
@endphp

@php
    $status = $jadwalPengisianInfo['status'] ?? null;
    $jadwal = $jadwalPengisianInfo['jadwal'] ?? null;

    $alertClass = match($status) {
        'active'   => 'alert-success',
        'upcoming' => 'alert-info',
        'ended'    => 'alert-danger',
        default    => null,
    };
@endphp

@if($status && $jadwal && $alertClass)
    <div class="alert {{ $alertClass }} d-flex align-items-center">
        <i class="fas fa-info-circle mr-2"></i>
        @if($status === 'active')
            <span>
                Pengisian dibuka dari {{ Helper::getTanggal($jadwal->tanggal_mulai) }}
                sampai {{ Helper::getTanggal($jadwal->tanggal_selesai) }} <strong>(sedang berlangsung)</strong>.
            </span>
        @elseif($status === 'upcoming')
            <span>
                Pengisian akan dibuka mulai {{ Helper::getTanggal($jadwal->tanggal_mulai) }}
                sampai {{ Helper::getTanggal($jadwal->tanggal_selesai) }}.
            </span>
        @elseif($status === 'ended')
            <span>
                Pengisian sudah ditutup pada {{ Helper::getTanggal($jadwal->tanggal_selesai) }}.
            </span>
        @endif
    </div>
@elseif(is_null($status))
    <div class="alert alert-secondary d-flex align-items-center">
        <i class="fas fa-info-circle mr-2"></i>
        <span>Belum ada konfigurasi jadwal pengisian untuk tahun ini.</span>
    </div>
@endif