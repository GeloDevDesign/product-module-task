@extends('layouts.app')

@section('banner')
   <x-banner :current-page="$title"></x-banner>
@endsection


@section('content')
<div class="row">

    <x-filters
        :action="route('admin.audit-logs.index')"
        :has-users="true"
        :users="$users"
        :has-daterange="true"
        :has-search="true"
        {{-- :no-per-page="true" --}}
    >
        <input type="hidden" name="per_page" value="{{ $filters['per_page'] ?? '' }}">
    </x-filters>

    <div class="col-md-12">
        <x-admin-panel
            :has-per-page="true"
            :per-page-route="route('admin.audit-logs.index')"
            :filters="$filters"
        >
            <div class="row">
                <div class="col-md-12">
                    <x-table-container>
                        <thead class="table-head">
                            <tr class="bg-dark text-white">
                                <th>User</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $activities as $key => $activity )
                                <tr class="table-tr">
                                    {{-- <td>{{ $activity->causer_id ? $activity->causer->first_name . ' ' . $activity->causer->last_name : '' }}</td> --}}
                                    <td class="table-td">{{ $activity->causer && $activity->causer->exists ? (optional($activity->causer)->first_name ?? '') . ' ' . (optional($activity->causer)->last_name ?? '') : '' }}</td>
                                    <td class="table-td">
                                        {{ $activity->created_at->format('M d, Y h:i A'); }}
                                    </td>
                                    <td class="table-td">
                                        {{ $activity->description }}
                                        @if( $activity->properties && $activity->properties->isNotEmpty() )
                                        <ul class="table-ul">
                                            @foreach( $activity->messages as $key => $message )
                                                <li><small>{{ $message }}</small></li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table-container>
                    <x-table-pagination
                        :action="route('admin.audit-logs.index')"
                        :filters="$filters"
                        :collection="$activities"
                    >
                    </x-table-pagination>
                </div>
            </div>
        </x-admin-panel>
    </div>

</div>
@endsection

@section('scripts')
<script>
    $('.daterange-basic').daterangepicker({
        parentEl: '.content-inner',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
        console.log('START')
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
        console.log('END')
        $(this).val('');
    });
</script>
@endsection
