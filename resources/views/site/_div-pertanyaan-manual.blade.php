@php
    use App\Constants\KuesionerPertanyaanJenisConstant;

    $jenis = $kuesionerPertanyaan->id_kuesioner_pertanyaan_jenis;
    $paddingLeft = ($level - 1) * 32 + 32;
@endphp

<div class="mb-4">
    @if ($jenis == KuesionerPertanyaanJenisConstant::LABEL)
        <div class="d-flex mb-1" style="padding-left: {{ $paddingLeft }}px">
            @if ($kuesionerPertanyaan->id_induk == null)
                <div class="text-primary font-weight-bold">{{ $no }}.&nbsp;</div>
            @endif
            
            <div>
                <div class="font-weight-bold text-primary">{{ $kuesionerPertanyaan->pertanyaan }}</div>
                @if (!empty($kuesionerPertanyaan->deskripsi))
                    <div class="text-muted" style="white-space: pre-line;">{!! nl2br(e($kuesionerPertanyaan->deskripsi)) !!}</div>
                @endif
            </div>
        </div>
    @else
        <div class="d-flex mb-2" style="padding-left: {{ $paddingLeft }}px">
            @php
                $classTextPrimary = "";
                if ($kuesionerPertanyaan->id_induk == null) {
                    $classTextPrimary = "text-primary";
                }
            @endphp

            @if ($kuesionerPertanyaan->id_induk == null)
                <div class="text-primary font-weight-bold">{{ $no }}.&nbsp;</div>
            @endif

            @if (!empty($kuesionerPertanyaan->kode))
                <div class="font-weight-bold {{ $classTextPrimary }}">{{ $kuesionerPertanyaan->kode }}.&nbsp;</div>
            @endif

            <div class="w-100">
                <label class="font-weight-bold d-block {{ $classTextPrimary }}">{{ $kuesionerPertanyaan->pertanyaan }}</label>

                @switch($jenis)
                    @case(KuesionerPertanyaanJenisConstant::ISIAN)
                        <input type="text" name="jawaban[{{ $kuesionerPertanyaan->id }}]" class="form-control" placeholder="Masukkan jawaban...">
                        @break

                    @case(KuesionerPertanyaanJenisConstant::PARAGRAF)
                        <textarea name="jawaban[{{ $kuesionerPertanyaan->id }}]" class="form-control" rows="4" placeholder="Tuliskan jawaban..."></textarea>
                        @break

                    @case(KuesionerPertanyaanJenisConstant::PILIHAN_TUNGGAL)
                        @foreach ($kuesionerPertanyaan->listKuesionerPertanyaanPilihan as $pilihan)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[{{ $kuesionerPertanyaan->id }}]" id="radio_{{ $pilihan->id }}" value="{{ $pilihan->id }}">
                                <label class="form-check-label" for="radio_{{ $pilihan->id }}">{{ $pilihan->nama }}</label>
                            </div>
                        @endforeach
                        @break

                    @case(KuesionerPertanyaanJenisConstant::PILIHAN_GANDA)
                        @foreach ($kuesionerPertanyaan->listKuesionerPertanyaanPilihan as $pilihan)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="jawaban[{{ $kuesionerPertanyaan->id }}][]" id="check_{{ $pilihan->id }}" value="{{ $pilihan->id }}">
                                <label class="form-check-label" for="check_{{ $pilihan->id }}">{{ $pilihan->nama }}</label>
                            </div>
                        @endforeach
                        @break

                    @case(KuesionerPertanyaanJenisConstant::UPLOAD)
                        <input type="file" name="jawaban[{{ $kuesionerPertanyaan->id }}]" class="form-control-file">
                        @break
                @endswitch
            </div>
        </div>
    @endif


    @php
        $level++;
    @endphp
    @foreach ($kuesionerPertanyaan->children as $sub)
        @include('site._div-pertanyaan-manual', [
            'kuesionerPertanyaan' => $sub,
            'level' => $level,
        ])
    @endforeach
</div>
