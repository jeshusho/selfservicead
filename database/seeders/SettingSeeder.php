<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['parameter' => 'logo_url', 'value' => 'https://visualizate.utpxpedition.com/sites/default/files/2020-02/logo-visualizate.png']);
        Setting::create(['parameter' => 'principal_link_text', 'value' => 'https://clave.utp.edu.pe']);
        Setting::create(['parameter' => 'principal_link_url', 'value' => 'https://clave.utp.edu.pe']);
        Setting::create(['parameter' => 'mda_whatsapp_text', 'value' => '994 693 775']);
        Setting::create(['parameter' => 'mda_whatsapp_url', 'value' => 'https://api.whatsapp.com/send/?phone=51994693775&text&type=phone_number&app_absent=0']);
        Setting::create(['parameter' => 'mda_phone_text', 'value' => '3159606']);
        Setting::create(['parameter' => 'mda_phone_url', 'value' => 'tel:+5113159606']);
        Setting::create(['parameter' => 'mda_extension_text', 'value' => '1444']);
        Setting::create(['parameter' => 'mda_portal_text', 'value' => 'https://mesadeayudautp.zendesk.com/']);
        Setting::create(['parameter' => 'mda_portal_url', 'value' => 'https://mesadeayudautp.zendesk.com/']);
        Setting::create(['parameter' => 'mda_mail_text', 'value' => 'mesadeayuda@utp.edu.pe']);
        Setting::create(['parameter' => 'mda_mail_url', 'value' => 'mailto:mesadeayuda@utp.edu.pe']);
        Setting::create(['parameter' => 'portal_text', 'value' => 'http://gttd.utp.edu.pe/']);
        Setting::create(['parameter' => 'portal_url', 'value' => 'http://gttd.utp.edu.pe/']);
        Setting::create(['parameter' => 'max_delay', 'value' => '30']);
    }
}
