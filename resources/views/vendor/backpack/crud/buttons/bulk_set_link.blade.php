@if ($crud->hasAccess('bulkSetLink') && $crud->get('list.bulkActions'))
  <a class="btn btn-sm btn-secondary bulk-button mb-2" href="javascript:void(0)" id="dropdownSetLink" onclick="bulkSetLink(this)" data-route="{{ url($crud->route) }}/bulk-set-link">
    <i class="la la-link"></i> Attach link
  </a>
@endif

@push('after_scripts')
    <script>
      if (typeof bulkSetLink != 'function') {
        function bulkSetLink(button) {

          if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
          {
            new Noty({
              type: "warning",
              text: "<strong>{{ trans('backpack::crud.bulk_no_entries_selected_title') }}</strong><br>{{ trans('backpack::crud.bulk_no_entries_selected_message') }}"
            }).show();

            return;
          }

          var message = "Enter the ID of the link you want to attach to these vehicles";


          // show confirm message
          swal({
            title: "{{ trans('backpack::base.warning') }}",
            text: message,
            content: 'input',
            button: {
              text: "Proceed",
              closeModal: false
            },
          })
          .then(linkId => {
            if (!linkId) throw null;

            var ajax_calls = [];

            // submit an AJAX delete call
            $.ajax({
              url: button.getAttribute('data-route'),
              type: 'POST',
              data: { entries: crud.checkedItems, link: linkId },
              success: function(result) {
                crud.checkedItems = [];
                crud.table.ajax.reload();

                // Show an alert with the result
                return new Noty({
                  type: "success",
                  text: "<strong>Success!</strong><br>The link with the ID "+linkId+" has been added to "+crud.checkedItems.length+" vehicles."
                }).show();
              },
              error: function(result) {
                // Show an alert with the result
                return new Noty({
                  type: "danger",
                  text: "<strong>Failed!</strong><br>The link could not be added. Please try again."
                }).show();
              }
            });
          });

          fetch('/api/links')
                  .then((response) => response.json())
                  .then(data => {
                    let availableLinks = data.data;
                    let linksUl = document.createElement('ul');
                    availableLinks.map(link => {
                      let linkLi = document.createElement('li');
                      linkLi.innerHTML = `<b>${link.id}</b> ${link.link}`
                      linksUl.appendChild(linkLi);
                    })
                    return document.getElementsByClassName('swal-text')[0].appendChild(linksUl);
                  })
        }
      }
    </script>
@endpush