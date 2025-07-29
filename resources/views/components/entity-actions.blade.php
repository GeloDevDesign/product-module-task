@props([
    'entityId',
    'edit',
    'noEdit' => false,
    'editLabel' => 'Edit',
    'noDelete' => false,
    'delete' => null,
    'deleteMsg' => null,
    'hasDownload' => false,
    'downloadUrl' => null,
    'name' => '',
])

@if ($hasDownload && !$downloadUrl)
    @php
        throw new Exception("Download button is enabled, but no download url provided.", 1);
    @endphp
@endif

<div class="icon-btn">

    @if($hasDownload)
        <a type="button" title="Edit" onclick="location.href='{{ $downloadUrl }}'" class="btn btn-success edit-btn btn-action btn-no-radius btn-square">
            <i class="fa fa fa-download" aria-hidden="true" style="margin-right: 0;"></i>
        </a>
    @endif

    @if(!$noEdit)
        <a type="button" title="Edit" onclick="location.href='{{ $edit }}'" class="btn btn-primary edit-btn btn-action btn-no-radius btn-square">
            <i class="icon-pencil"></i>
        </a>
    @endif

    {!! $slot !!}

    @if($delete && (!$noDelete))
        <a type="button" title="Delete" class="btn btn-danger del-btn btn-action btn-no-radius btn-square" data-bs-toggle="modal" data-bs-target="#deleteConfirm-{{ $entityId }}">
            <i class="icon-trash" aria-hidden="true"></i>
        </a>
    @endif
</div>

<x-delete-confirm-modal :action="$delete" :entity-id="$entityId">
    <div class="mt-2">
        <p class="text-sm text-gray-500">
        @if ($deleteMsg)
            {{ $deleteMsg }}
        @else
            Are you sure you want to delete <u>{{ $name }}</u>?
        @endif
        </p>
    </div>
</x-delete-confirm-modal>