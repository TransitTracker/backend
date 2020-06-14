@if ($crud->hasAccess('makeActive'))
  <a href="javascript:void(0)" onclick="makeActive(this)" data-route="{{ url($crud->route.'/'.$entry->getKey().'/make-active') }}" class="btn btn-sm btn-link" data-button-type="makeActive">
    @if($entry->is_active)
      <i class="la la-minus"></i> Remove from active
    @else
      <i class="la la-plus"></i> Make active
    @endif
  </a>
@endif

@push('after_scripts') @if(request()->ajax()) @endpush @endif
    <script>
      if(typeof makeActive != 'function') {
        $("[data-button-type=make-active]").unbind('click');

        function makeActive(button) {
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