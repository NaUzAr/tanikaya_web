<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use App\Models\Device;
use App\Models\DeviceSensor;
use App\Models\DeviceOutput;
use App\Models\DeviceSetting;
use App\Models\DeviceSchedule;
use App\Models\UserDevice;
use App\Models\User;

class SmartGhTmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deviceConfigs = [
            ['name' => 'Smart GH TM 1', 'topic' => '/smartgh_tm_01'],
            ['name' => 'Smart GH TM 2', 'topic' => '/smartgh_tm_02'],
            ['name' => 'Smart GH TM 3', 'topic' => '/smartgh_tm_03'],
            ['name' => 'Smart GH TM 4', 'topic' => '/smartgh_tm_04'],
            ['name' => 'Smart GH TM 5', 'topic' => '/smartgh_tm_05'],
        ];

        $sensorsData = [
            ['sensor_name' => 'ni_SUHU', 'sensor_label' => 'Suhu (Temperature)', 'unit' => '°C', 'mqtt_key' => 'ni_SUHU'],
            ['sensor_name' => 'ni_KELEM', 'sensor_label' => 'Kelembaban (Humidity)', 'unit' => '%', 'mqtt_key' => 'ni_KELEM'],
            ['sensor_name' => 'ni_LUX', 'sensor_label' => 'Intensitas Cahaya', 'unit' => 'lux', 'mqtt_key' => 'ni_LUX'],
            ['sensor_name' => 'ni_EC', 'sensor_label' => 'EC (Electrical Conductivity)', 'unit' => 'mS/cm', 'mqtt_key' => 'ni_EC'],
            ['sensor_name' => 'ni_TDS', 'sensor_label' => 'TDS (Total Dissolved Solids)', 'unit' => 'ppm', 'mqtt_key' => 'ni_TDS'],
            ['sensor_name' => 'ni_PH', 'sensor_label' => 'pH', 'unit' => '', 'mqtt_key' => 'ni_PH'],
        ];

        $outputsData = [
            ['output_name' => 'fan', 'output_label' => 'Kipas/Fan', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_air_input', 'output_label' => 'Air Baku', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_mixing', 'output_label' => 'Mixing Process', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_dosing', 'output_label' => 'Dosing Pump', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_ph_up', 'output_label' => 'pH Up Pump', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_ph_down', 'output_label' => 'pH Down Pump', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'irrigation_pump', 'output_label' => 'Pompa Irigasi (Multi-Zona)', 'output_type' => 'multi_zone', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_misting', 'output_label' => 'Misting/Kabut', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_lampu', 'output_label' => 'Lampu Grow Light', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_sld_op', 'output_label' => 'Shading Net Open', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_sld_tu', 'output_label' => 'Shading Net Close', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
            ['output_name' => 'sts_cool', 'output_label' => 'Cooling System', 'output_type' => 'boolean', 'unit' => '', 'default_value' => 0, 'current_value' => 0, 'automation_mode' => 'none', 'max_schedules' => 8, 'max_sectors' => 1],
        ];

        $settingsData = [
            'ats_suhu' => '28',
            'bwh_suhu' => '20',
            'ats_kelem' => '10',
            'bwh_kelem' => '5',
            'ats_ph' => '6',
            'bwh_ph' => '4.1',
            'ats_tds' => '500',
            'bwh_tds' => '300',
        ];

        // Ambil admin/pengguna utama untuk dipasangkan (agar langsung terlihat di dashboard user)
        $users = User::all();

        foreach ($deviceConfigs as $cfg) {
            $device = Device::where('name', $cfg['name'])->first();

            if (!$device) {
                $token = Str::random(16);
                $tableName = 'log_' . $token;

                $device = Device::create([
                    'name' => $cfg['name'],
                    'type' => 'smart_gh',
                    'mqtt_topic' => $cfg['topic'],
                    'token' => $token,
                    'table_name' => $tableName,
                    'max_time_schedules' => 5,
                    'max_sensor_automations' => 3,
                ]);

                $this->command->info("Created device: {$cfg['name']} (Token: {$token})");
            } else {
                $tableName = $device->table_name;
                $this->command->info("Device already exists: {$cfg['name']} (Token: {$device->token})");
            }

            // 1. Buat tabel log telemetri jika belum ada
            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->float('ni_SUHU')->nullable();
                    $table->float('ni_KELEM')->nullable();
                    $table->float('ni_LUX')->nullable();
                    $table->float('ni_EC')->nullable();
                    $table->float('ni_TDS')->nullable();
                    $table->float('ni_PH')->nullable();
                    $table->timestamp('recorded_at')->useCurrent();
                });
                $this->command->info("Created table: {$tableName}");
            }

            // 2. Insert sensors jika belum ada
            foreach ($sensorsData as $sensor) {
                DeviceSensor::firstOrCreate(
                    [
                        'device_id' => $device->id,
                        'sensor_name' => $sensor['sensor_name'],
                    ],
                    [
                        'sensor_label' => $sensor['sensor_label'],
                        'unit' => $sensor['unit'],
                        'mqtt_key' => $sensor['mqtt_key'],
                    ]
                );
            }

            // 3. Insert outputs jika belum ada
            foreach ($outputsData as $output) {
                DeviceOutput::firstOrCreate(
                    [
                        'device_id' => $device->id,
                        'output_name' => $output['output_name'],
                    ],
                    $output
                );
            }

            // 4. Insert device settings (ambang batas otomatisasi)
            foreach ($settingsData as $key => $val) {
                DeviceSetting::firstOrCreate(
                    [
                        'device_id' => $device->id,
                        'key' => $key,
                    ],
                    [
                        'value' => $val,
                    ]
                );
            }

            // 5. Insert schedule configuration
            DeviceSchedule::firstOrCreate(
                [
                    'device_id' => $device->id,
                    'schedule_name' => 'schedule',
                ],
                [
                    'schedule_label' => 'Waktu + Hari + Durasi + Sektor + Jenis',
                    'output_key' => 'general',
                    'schedule_mode' => 'time_days_duration_sector_type',
                    'max_slots' => 14,
                    'max_sectors' => 1,
                ]
            );

            // 6. Hubungkan device ke user (Admin & Swaratani) agar langsung muncul di monitoring
            foreach ($users as $user) {
                UserDevice::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'device_id' => $device->id,
                    ],
                    [
                        'custom_name' => $cfg['name'],
                        'is_favorite' => false,
                    ]
                );
            }
        }

        // Trigger cache listener update
        Cache::put('mqtt_devices_changed', true, 60);

        $this->command->info("Semua 5 device Smart GH TM berhasil dibuat!");
    }
}
