@php
    $paddingLeft = ($level - 1) * 32 + 32;
    $oldValue = old("jawaban.{$kuesionerPertanyaan->id}");
@endphp

<div class="mb-4">
    <div class="d-flex mb-2" style="padding-left: {{ $paddingLeft }}px">
        <div class="w-100">
            <label class="font-weight-bold d-block mb-2">
                {{ $no }}.
                @if (!empty($kuesionerPertanyaan->kode))
                    {{ $kuesionerPertanyaan->kode }}.&nbsp;
                @endif
                {{ $kuesionerPertanyaan->pertanyaan }}
            </label>

            <div class="star-rating d-flex" id="star_rating_{{ $kuesionerPertanyaan->id }}">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="fa fa-star"
                        data-id-pertanyaan="{{ $kuesionerPertanyaan->id }}"
                        data-rating="{{ $i }}"
                        data-description="Bintang {{ $i }}">
                    </span>
                @endfor
            </div>

            <input type="hidden" name="jawaban[{{ $kuesionerPertanyaan->id }}]" value="0">
        </div>
    </div>

    @foreach ($kuesionerPertanyaan->children as $sub)
        @include('site._div-pertanyaan-manual', [
            'kuesionerPertanyaan' => $sub,
            'level' => $level + 1,
        ])
    @endforeach
</div>

@push('styles')
<style>
    .star-rating {
        gap: 0.5rem;
    }
    .star-rating .fa-star {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .star-rating .fa-star:hover {
        transform: scale(1.2);
    }
    .star-rating .fa-star.checked {
        color: #ffc107;
    }
    .star-rating.disabled .fa-star.checked {
        color: #e1aa05;
    }
    .star-rating .fa-star.animate {
        animation: pop 0.3s ease;
    }
    @keyframes pop {
        0%   { transform: scale(1); }
        50%  { transform: scale(1.4); }
        100% { transform: scale(1); }
    }
    .star-rating span + span {
        margin-left: 0.5rem;
    }
    .star-rating.disabled .fa-star {
        cursor: default !important;
        pointer-events: none;
        transition: none;
    }
    .star-rating.disabled .fa-star:hover {
        transform: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        var rating = 0;
        var description = "";
        var idPertanyaan = null;

        $(".star-rating:not(.disabled) .fa-star").on("click", function() {
            rating = $(this).data("rating");
            description = $(this).data("description");
            idPertanyaan = $(this).data("id-pertanyaan");

            updateStars(rating, description, idPertanyaan);
            animateStar(this);

            $(`#invalid_rating_${idPertanyaan}`).removeClass("d-block");
        });

        function updateStars(rating, description, idPertanyaan) {
            $(`#star_rating_${idPertanyaan} .fa-star`).each(function() {
                var star = $(this).data("rating");
                $(this).toggleClass("checked", star <= rating);
            });

            $("#rating_text_" + idPertanyaan).text(description);
            $(`input[name='jawaban[${idPertanyaan}]']`).val(rating);
        }

        function animateStar(el) {
            $(el).addClass("animate");
            setTimeout(function() {
                $(el).removeClass("animate");
            }, 300);
        }
    });
</script>
@endpush
