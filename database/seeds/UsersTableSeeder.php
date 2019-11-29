<?php

use App\Site;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Site::truncate();
        $site = new Site();
        $site->id_site = 'MLA';
        $site->currency = 'ARS';
        $site->name = 'Argentina';
        $site->save();

        $site = new Site();
        $site->id_site = 'MEC';
        $site->currency = 'USD';
        $site->name = 'Ecuador';
        $site->save();

        $site = new Site();
        $site->id_site = 'PAB';
        $site->currency = 'MPA';
        $site->name = 'Panamá';
        $site->save();

        $site = new Site();
        $site->id_site = 'MRD';
        $site->currency = 'DOP';
        $site->name = 'Dominicana';
        $site->save();

        $site = new Site();
        $site->id_site = 'MCR';
        $site->currency = 'CRC';
        $site->name = 'Costa Rica';
        $site->save();

        $site = new Site();
        $site->id_site = 'MLV';
        $site->currency = 'VES';
        $site->name = 'Venezuela';
        $site->save();

        $site = new Site();
        $site->id_site = 'MBO';
        $site->currency = 'BOB';
        $site->name = 'Bolivia';
        $site->save();

        $site = new Site();
        $site->id_site = 'MCU';
        $site->currency = 'CUP';
        $site->name = 'Cuba';
        $site->save();

        $site = new Site();
        $site->id_site = 'MLC';
        $site->currency = 'CLP';
        $site->name = 'Chile';
        $site->save();

        $site = new Site();
        $site->id_site = 'MSV';
        $site->currency = 'USD';
        $site->name = 'El Salvador';
        $site->save();

        $site = new Site();
        $site->id_site = 'MLM';
        $site->currency = 'MXN';
        $site->name = 'Mexico';
        $site->save();

        $site = new Site();
        $site->id_site = 'MPE';
        $site->currency = 'PEN';
        $site->name = 'Perú';
        $site->save();

        $site = new Site();
        $site->id_site = 'MHN';
        $site->currency = 'HNL';
        $site->name = 'Honduras';
        $site->save();

        $site = new Site();
        $site->id_site = 'MPY';
        $site->currency = 'PYG';
        $site->name = 'Paraguay';
        $site->save();

        $site = new Site();
        $site->id_site = 'MGT';
        $site->currency = 'GTQ';
        $site->name = 'Guatemala';
        $site->save();

        $site = new Site();
        $site->id_site = 'MCO';
        $site->currency = 'COP';
        $site->name = 'Colombia';
        $site->save();

        $site = new Site();
        $site->id_site = 'MLU';
        $site->currency = 'UYU';
        $site->name = 'Uruguay';
        $site->save();

        $site = new Site();
        $site->id_site = 'MPT';
        $site->currency = 'EUR';
        $site->name = 'Portugal';
        $site->save();

        $site = new Site();
        $site->id_site = 'MNI';
        $site->currency = 'NIO';
        $site->name = 'Nicaragua';
        $site->save();

        $site = new Site();
        $site->id_site = 'MLB';
        $site->currency = 'BRL';
        $site->name = 'Brasil';
        $site->save();
    }
}
