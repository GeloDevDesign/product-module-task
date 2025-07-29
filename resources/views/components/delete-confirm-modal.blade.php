@props(['action', 'entityId'])

<div class="modal fade" id="deleteConfirm-{{ $entityId }}" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmLabel">
          <i class="fa fa-exclamation-triangle text-danger me-1"></i>
          Delete User
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background:none; padding: 0; border:0; font-size: 24px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ $action }}">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          {!! $slot !!}
        </div>
        <div class="modal-footer">
          <x-button type="button" data-bs-dismiss="modal" class="btn-primary me-2" :action="'back'">Cancel</x-button>
          <x-button type="submit" class="btn-danger" :action="'delete'">Confirm Delete</x-button>
        </div>
      </form>
    </div>
  </div>
</div>