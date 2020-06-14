@if ($crud->hasAccess('refresh'))
  <a href="javascript:void(0)" onclick="updateGtfs(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/update-gtfs') }}" class="btn btn-sm btn-link" data-button-type="update-gtfs">
    <i class="la la-download"></i> Update GTFS
  </a>
@endif

@push('after_scripts') @if(request()->ajax()) @endpush @endif
    <script>
      if(typeof updateGtfs != 'function') {
        $("[data-button-type=update-gtfs]").unbind('click');

        function updateGtfs(button) {
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