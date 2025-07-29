@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'Back Ups'"></x-banner>
@endsection


@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="mb-3 d-inline-flex" style="float: right;">
            <a href="{{ route('admin.backups.generate-full-backup') }}">
                <button type="button" class="mb-2 btn btn-labeled btn-labeled-start btn-default btn-primary me-2" data-bs-dismiss="modal">
                    <span class="btn-labeled-icon bg-black bg-opacity-20">
                        <i class="fa fa-plus"></i>
                    </span>
                    Create Full Back Up
                </button>
            </a>
            <a href="{{ route('admin.backups.generate-db-backup') }}">
                <button type="button" class="btn btn-labeled btn-labeled-start btn-default btn-primary " data-bs-dismiss="modal">
                    <span class="btn-labeled-icon bg-black bg-opacity-20">
                        <i class="fa fa-plus"></i>
                    </span>
                    Create DB Back Up
                </button>
            </a>
        </div>
    </div>

    <div class="col-md-12">
        <x-admin-panel
            :has-per-page="true"
            :per-page-route="route('admin.backups.index')"
            :filters="$filters"
        >
            <div class="row">
                <div class="col-md-12">
                    <x-table-container>
                        <thead class="table-head">
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $backups as $key => $backup )
                                <tr class="table-tr">
                                    <td class="table-td">
                                    {{ formatFileLastModified($backup) }}
                                    </td>
                                    <td class="table-td">
                                    @php
                                        $explodeUpdate = explode('/', $backup);
                                        $sanitizedUpdate = $explodeUpdate && count($explodeUpdate) > 1 ? $explodeUpdate[count($explodeUpdate) - 1] : $updateValue;
                                        
                                    @endphp
                                    {{ $sanitizedUpdate }}
                                    </td>
                                    <td class="table-td">
                                    {{ getFileSizeMB($backup) }}
                                    </td>
                                    <td style = "display: flex;">
                                    {{-- <div class="icon-btn">
                                        <a type="button" title="Download" onclick="location.href='{{ route('admin.backups.download-backup', ['file' => $backup] ) }}'" class="btn btn-success edit-btn btn-action btn-no-radius btn-square" style="margin-right: 5px; border: 0;">
                                            <i class="fa fa fa-download" aria-hidden="true" style="margin-right: 0;"></i>
                                        </a>
                                    </div> --}}
                                    <x-entity-actions
                                        :entity-id="'file-'.$key"
                                        :no-edit="true"
                                        :has-download="true"
                                        :download-url="route('admin.backups.download-backup', ['file' => $backup] )"
                                        :delete="route('admin.backups.delete-backup', ['file' => $backup] )">
                                    </x-entity-actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                    No Data Available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table-container>
                    <x-table-pagination
                        :action="route('admin.backups.index')"
                        :filters="$filters"
                        :collection="$backups"
                    >
                    </x-table-pagination>
                </div>
            </div>

        </x-admin-panel>
    </div>

 </div>
@endsection