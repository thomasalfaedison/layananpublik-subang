@php
    /**
     * @var \App\Models\LayananKomponen $model
     **/
@endphp

<div class="card card-default">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 150px; text-align:right">Komponen</th>
                <td>
                    {{ $model->refLayananKomponen?->nama }}
                </td>
            </tr>
        </table>
    </div>
</div>