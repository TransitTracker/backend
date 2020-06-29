<?php

use App\Agency;
use Illuminate\Database\Migrations\Migration;

class ChangeRegionRealtimeOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Agency::all() as $agency) {
            if ($agency->realtime_options) {
                $old = json_decode($agency->realtime_options);
                $new = [
                    'realtime_method' => $old->method,
                    'header_name' => key($old->header),
                    'header_value' => current($old->header),
                    'param_name' => key($old->param),
                    'param_value' => current($old->param),
                ];
            } else {
                $new = [
                    'realtime_method' => '',
                    'header_name' => '',
                    'header_value' => '',
                    'param_name' => '',
                    'param_value' => '',
                ];
            }

            $agency->realtime_options = json_encode($new);
            $agency->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (Agency::all() as $agency) {
            $old = json_decode($agency->realtime_options);

            $new = [
                'realtime_method' => $old->realtime_method,
                'header_name' => $old->header_name,
                'header_value' => $old->header_value,
                'param_name' => $old->param_name,
                'param_value' => $old->param_value,
            ];

            $agency->realtime_options = json_encode($new);
            $agency->save();
        }
    }
}
