<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maps;
class MapsSeeder extends Seeder
{
    public function run(): void
    {
        $maps = [
            [
                'judul_mapset' => 'Peta Batas Administrasi Desa',
                'deskripsi' => 'Peta yang menampilkan garis batas wilayah administrasi tingkat desa/kelurahan.',
                'skala' => '1:10.000',
                'sistem_proyeksi' => 'UTM',
                'kategori_id' => 1,
                'organisasi_id' => 1,
                'tipe_layer' => 'Polygon',
                'link_openlayer' => 'https://geoserver.jatimprov.go.id/geoserver/diskominfo/wms?service=WMS&version=1.1.0&request=GetMap&layers=diskominfo%3Aview_jmlh_ds_yng_sdh_mndkmntskn_tnh_ks_ds_mnrt_kbptnkt&bbox=110.89528623700005%2C-8.780222556999945%2C116.27018900000007%2C-5.042965328999969&width=768&height=534&srs=EPSG%3A4326&styles=&format=application/openlayers',
                'tingkat_penyajian' => 'Desa/Kelurahan',
                'cakupan_wilayah' => 'Kabupaten/Kota',
                'tahun_data' => 2026,
            ],
            [
                'judul_mapset' => 'Sebaran Fasilitas Kesehatan',
                'deskripsi' => 'Peta titik lokasi puskesmas, klinik, dan rumah sakit.',
                'skala' => '1:25.000',
                'sistem_proyeksi' => 'WGS 84',
                'kategori_id' => 9,
                'organisasi_id' => 2,
                'tipe_layer' => 'Point',
                'link_openlayer' => 'https://geoserver.jatimprov.go.id/geoserver/diskominfo/wms?service=WMS&version=1.1.0&request=GetMap&layers=diskominfo%3Aview_jmlh_klrg_pnrm_mnft_yng_dfslts_prgrm_jtm_psp&bbox=110.89528623700005%2C-8.780222556999945%2C116.27018900000007%2C-5.042965328999969&width=768&height=534&srs=EPSG%3A4326&styles=&format=application/openlayers',
                'tingkat_penyajian' => 'Kecamatan',
                'cakupan_wilayah' => 'Provinsi',
                'tahun_data' => 2025,
            ],
            [
                'judul_mapset' => 'Jaringan Jalan Arteri',
                'deskripsi' => 'Peta garis yang menunjukkan rute jalan arteri.',
                'skala' => '1:50.000',
                'sistem_proyeksi' => 'UTM',
                'kategori_id' => 12,
                'organisasi_id' => 1,
                'tipe_layer' => 'Line',
                'link_openlayer' => 'https://geoserver.jatimprov.go.id/geoserver/diskominfo/wms?service=WMS&version=1.1.0&request=GetMap&layers=diskominfo%3Aview_jmlh_msyrkt_mskn_dn_tdk_mmp_yng_dpt_mngkss_plynn_kshtn&bbox=110.89528623700005%2C-8.780222556999945%2C116.27018900000007%2C-5.042965328999969&width=768&height=534&srs=EPSG%3A4326&styles=&format=application/openlayers',
                'tingkat_penyajian' => 'Provinsi',
                'cakupan_wilayah' => 'Provinsi',
                'tahun_data' => 2024,
            ]
        ];

        foreach ($maps as $map) {
            Maps::create($map);
        }
    }
}
