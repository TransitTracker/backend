@if ($crud->hasAccess('refresh'))
  <a href="javascript:void(0)" onclick="updateIcons(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/update-icons') }}" class="btn btn-sm btn-link" data-button-type="update-icons">
    <i class="la la-icons"></i> Update icons
  </a>
@endif

@push('after_scripts') @if(request()->ajax()) @endpush @endif
    <script>
      if(typeof updateIcons != 'function') {
        $("[data-button-type=update-icons]").unbind('click');

        function updateIcons(button) {
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