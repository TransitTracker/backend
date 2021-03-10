@if ($crud->hasAccess('bulkSetIcon') && $crud->get('list.bulkActions'))
  <div class="dropdown">
    <a class="btn btn-sm btn-secondary bulk-button dropdown-toggle mb-2" href="#" role="button" id="dropdownSetIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="la la-icons"></i> Change icon
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdownSetIcon">
      <a href="javascript:void(0)" onclick="bulkSetIcon(this)" class="dropdown-item" data-icon="bus"><i class="la la-bus"></i> Bus</a>
      <a href="javascript:void(0)" onclick="bulkSetIcon(this)" class="dropdown-item" data-icon="train"><i class="la la-train"></i> Train</a>
      <a href="javascript:void(0)" onclick="bulkSetIcon(this)" class="dropdown-item" data-icon="tram"><i class="la la-tram"></i> Tram</a>
    </div>
  </div>
@endif

@push('after_scripts')
    <script>
      if (typeof bulkSetIcon != 'function') {
        function bulkSetIcon(button) {

          if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
          {
            new Noty({
              type: "warning",
              text: "<strong>{{ trans('backpack::crud.bulk_no_entries_selected_title') }}</strong><br>{{ trans('backpack::crud.bulk_no_entries_selected_message') }}"
            }).show();

            return;
          }

          var message = "Are you sure you want to change the icon for :number entries?";
          message = message.replace(":number", crud.checkedItems.length);

          // show confirm message
          swal({
            title: "{{ trans('backpack::base.warning') }}",
            text: message,
            icon: "warning",
            buttons: {
              cancel: {
                text: "{{ trans('backpack::crud.cancel') }}",
                value: null,
                visible: true,
                className: "bg-secondary",
                closeModal: true,
              },
              delete: {
                text: "Proceed",
                value: true,
                visible: true,
                className: "bg-primary",
              }
            },
          }).then((value) => {
            if (value) {
              var ajax_calls = [];
              var clone_route = "{{ url($crud->route) }}/bulk-set-icon";

              // submit an AJAX delete call
              $.ajax({
                url: clone_route,
                type: 'POST',
                data: { entries: crud.checkedItems, icon: button.getAttribute('data-icon') },
                success: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "success",
                    text: "<strong>Success!</strong><br>"+crud.checkedItems.length+" icons have been set."
                  }).show();

                  crud.checkedItems = [];
                  crud.table.ajax.reload();
                },
                error: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "danger",
                    text: "<strong>Failed!</strong><br>One or more icons could not be changed. Please try again."
                  }).show();
                }
              });
            }
          });
        }
      }
    </script>
@endpush