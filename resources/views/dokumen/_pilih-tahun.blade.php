<form action="{{ route(\App\Http\Controllers\DokumenController::ROUTE_VIEW, ['slug' => $slug]) }}" method="GET" class="mb-3">
    @if (\App\Components\Session::isAdmin())
        <input type="hidden" name="id_instansi" value="{{ $dokumenModel->id_instansi }}">
    @endif
    <div class="form-inline">
        <label for="tahun-dokumen" class="mr-2">Tahun Dokumen</label>
        <input type="number" id="tahun-dokumen" name="tahun" class="form-control mr-2" min="1901" max="2155" value="{{ $tahun }}" required>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </div>
</form>
