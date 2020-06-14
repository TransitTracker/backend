@if ($crud->hasAccess('refresh'))
  <a href="javascript:void(0)" onclick="refresh(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/refresh') }}" class="btn btn-sm btn-link" data-button-type="refresh">
    <i class="la la-sync"></i> Refresh
  </a>
@endif

@push('after_scripts') @if(request()->ajax()) @endpush @endif
    <script>
      if(typeof refresh != 'function') {
        $("[data-button-type=refresh]").unbind('click');

        function refresh(button) {
          $.ajax({
            url: button.getAttribute('data-route'),
            type: 'POST',
            success: function (result) {
              new Noty({
                type: 'success',
                text: '<strong>Success!</strong>'
              }).show();

              if (typeof crud !== 'undefined') {
                crud.table.ajax.reload();
              }
            },
            error: function(result) {
              new Noty({
                type: 'warning',
                text: '<strong>Failed!</strong>'
              }).show();
            }
          });
        }
      }
    </script>
@if(!request()->ajax()) @endpush @endif