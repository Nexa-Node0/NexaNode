<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PSGCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $path = storage_path('app/psgc.csv');

// Read all rows into memory first
        $file   = fopen($path, 'r');
        $header = fgetcsv($file);
        $rows   = [];
        while (($row = fgetcsv($file)) !== false) {
            $rows[] = $row;
        }
        fclose($file);

// Reverse so we process lowest PSGC codes first (ascending order)
        $rows = array_reverse($rows);

        DB::transaction(function () use ($rows) {
            // Ensure Philippines exists
            $countryId = DB::table('countries')->where('name', 'Philippines')->value('id');
            if (! $countryId) {
                $countryId = DB::table('countries')->insertGetId(['name' => 'Philippines']);
            }

            // Ensure Metro Manila exists (NCR has no province-level entry)
            $metroManilaId = DB::table('states')->where('name', 'Metro Manila')->value('id');
            if (! $metroManilaId) {
                $metroManilaId = DB::table('states')->insertGetId([
                    'name'       => 'Metro Manila',
                    'country_id' => $countryId,
                    'psgc_code'  => '13300',
                ]);
            }

            // === PASS 1: Provinces ===
            foreach ($rows as $row) {
                $psgc  = $row[0] ?? null;
                $name  = $row[1] ?? null;
                $level = $row[3] ?? null;

                if (! $psgc || ! $name || $level !== 'Prov') {
                    continue;
                }

                $provinceCode = substr($psgc, 0, 5);
                $exists       = DB::table('states')->where('psgc_code', $provinceCode)->exists();
                if (! $exists) {
                    DB::table('states')->insert([
                        'psgc_code'  => $provinceCode,
                        'name'       => $name,
                        'country_id' => $countryId,
                    ]);
                } else {
                    DB::table('states')
                        ->where('psgc_code', $provinceCode)
                        ->update(['name' => $name, 'country_id' => $countryId]);
                }
            }

            // === PASS 2: Cities / Municipalities ===
            foreach ($rows as $row) {
                $psgc  = $row[0] ?? null;
                $name  = $row[1] ?? null;
                $level = $row[3] ?? null;

                if (! $psgc || ! $name || ! in_array($level, ['City', 'Mun'])) {
                    continue;
                }

                $provinceCode = substr($psgc, 0, 5);
                $provinceId   = DB::table('states')->where('psgc_code', $provinceCode)->value('id');

                // NCR: no matching province → use Metro Manila
                if (! $provinceId) {
                    $provinceId = $metroManilaId;
                }

                $cityCode = substr($psgc, 0, 7);
                $exists   = DB::table('cities')->where('psgc_code', $cityCode)->exists();
                if (! $exists) {
                    DB::table('cities')->insert([
                        'psgc_code' => $cityCode,
                        'name'      => $name,
                        'state_id'  => $provinceId,
                    ]);
                } else {
                    DB::table('cities')
                        ->where('psgc_code', $cityCode)
                        ->update(['name' => $name, 'state_id' => $provinceId]);
                }
            }

            // === PASS 3: Barangays ===
            foreach ($rows as $row) {
                $psgc  = $row[0] ?? null;
                $name  = $row[1] ?? null;
                $level = $row[3] ?? null;

                if (! $psgc || ! $name || $level !== 'Bgy') {
                    continue;
                }

                $cityCode = substr($psgc, 0, 7);
                $cityId   = DB::table('cities')->where('psgc_code', $cityCode)->value('id');

                if (! $cityId) {
                    Log::warning("PSGC Seeder: No city for barangay {$psgc} ({$name}), city code {$cityCode}");
                    continue;
                }

                $exists = DB::table('barangays')->where('psgc_code', $psgc)->exists();
                if (! $exists) {
                    DB::table('barangays')->insert([
                        'psgc_code' => $psgc,
                        'name'      => $name,
                        'city_id'   => $cityId,
                    ]);
                } else {
                    DB::table('barangays')
                        ->where('psgc_code', $psgc)
                        ->update(['name' => $name, 'city_id' => $cityId]);
                }
            }
        });
    }
}
