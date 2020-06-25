<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url_province = "https://api.rajaongkir.com/starter/province?key=771cc86d8a388d9bf5b406d644fd558a";
        $json_str     = file_get_contents($url_province);
        $json_obj     = json_decode($json_str);
        $provinces    = [];
        foreach ($json_obj->rajaongkir->results as $province) {
            $provinces[] = [
                'id'   => $province->province_id,
                'name' => $province->province,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        DB::table('provinces')->insert($provinces);

        $url_city = "https://api.rajaongkir.com/starter/city?key=771cc86d8a388d9bf5b406d644fd558a";
        $json_str = file_get_contents($url_city);
        $json_obj = json_decode($json_str);
        $cities   = [];
        foreach ($json_obj->rajaongkir->results as $city) {
            $cities[] = [
                'id'          => $city->city_id,
                'province_id' => $city->province_id,
                'name'        => $city->type. ' ' .$city->city_name,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ];
        }

        DB::table('regencies')->insert($cities);
    }
}
