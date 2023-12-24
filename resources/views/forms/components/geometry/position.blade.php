<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle('{{ $getStatePath() }}'), isOk: false }"
        class="flex gap-2"
        data-dispatch="load-leaflet"
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('terra-draw')), @js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('leaflet'))]"
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('leaflet'))]"
    >
        <div class="flex flex-col">
            <x-filament::icon-button
                    icon="gmdi-ads-click-o"
                    x-on:click="window.draw.setMode('select')"
                    label="Set map to selection mode"
            />
            <x-filament::icon-button
                    icon="gmdi-pin-drop"
                    x-on:click="window.draw.setMode('point')"
                    label="Set map to point mode"
            />
            <div class="grow"></div>
            <x-filament::icon-button
                    x-show="isOk"
                    disabled
                    icon="gmdi-check"
                    color="success"
                    label="Everything is good!"
            />
        </div>
        <div id="map" class="grow" style="height: 500px;" x-on:load-leaflet-js.window="start()"></div>
        <script>
          const start = () => {
            var map = L.map('map').setView([51.505, -0.09], 13);
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            window.draw = new terraDraw.TerraDraw({
              adapter: new terraDraw.TerraDrawLeafletAdapter({
                lib: L,
                map: map,
                coordinatePrecision: 5,
              }),
              modes: [
                new terraDraw.TerraDrawPointMode(),
                new terraDraw.TerraDrawSelectMode({
                  flags: {
                    point: {
                      feature: {
                        draggable: true,
                        deletable: true,
                      },
                    },
                  }
                }),
              ]
            })

            window.draw.on('finish', function (event) {
                if (typeof event !== 'string') {
                  return
                }

                const snapshot = window.draw.getSnapshot()

                  if (snapshot.length === 0) {
                    return
                  }

                if (snapshot.length > 1) {
                  new FilamentNotification()
                    .title('Too many points')
                    .body('Please select only one point. Go to select mode, select points and click the DELETE key to proceed')
                    .icon('gmdi-warning')
                    .iconColor('danger')
                    .send()
                }

                if (snapshot[0].geometry.type !== 'Point') {
                  window.draw.clear()
                  new FilamentNotification()
                    .title('Incorrect type')
                    .body('The map has been reset, please try again')
                    .icon('gmdi-warning')
                    .iconColor('danger')
                    .send()
                }

              $data.isOk = true
            })

            draw.start()
            draw.setMode('point')

          }

          // startIfReady()
        </script>
    </div>
</x-dynamic-component>
