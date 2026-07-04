<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpatialDataController extends Controller
{
    /**
     * Get list of user tables in the PostgreSQL database.
     */
    public function getTables()
    {
        try {
            $tables = DB::connection('pgsql')->select("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name != 'spatial_ref_sys'
                ORDER BY table_name ASC
            ");
            
            return response()->json($tables);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal terhubung ke database PostgreSQL. Pastikan pgsql aktif dan terkonfigurasi di .env.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of columns in a PostgreSQL table.
     */
    public function getColumns($table)
    {
        try {
            // Validate table name to prevent SQL injection
            $exists = DB::connection('pgsql')->selectOne("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name = :table
            ", ['table' => $table]);

            if (!$exists) {
                return response()->json(['error' => 'Tabel tidak ditemukan di PostgreSQL.'], 404);
            }

            $columns = DB::connection('pgsql')->select("
                SELECT column_name, data_type 
                FROM information_schema.columns 
                WHERE table_schema = 'public' 
                  AND table_name = :table
                ORDER BY ordinal_position ASC
            ", ['table' => $table]);

            return response()->json($columns);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal membaca kolom tabel.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export PostgreSQL table geometries and attributes directly as GeoJSON.
     */
    public function getGeoJSON($table)
    {
        try {
            // Validate table name to prevent SQL injection
            $exists = DB::connection('pgsql')->selectOne("
                SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = 'public' 
                  AND table_name = :table
            ", ['table' => $table]);

            if (!$exists) {
                return response()->json(['error' => 'Tabel tidak ditemukan di PostgreSQL.'], 404);
            }

            // Find the geometry column dynamically (usually 'geom', 'geometry', or 'wkb_geometry')
            $geomColumnRow = DB::connection('pgsql')->selectOne("
                SELECT column_name 
                FROM information_schema.columns 
                WHERE table_schema = 'public' 
                  AND table_name = :table 
                  AND (data_type = 'USER-DEFINED' OR udt_name = 'geometry')
                LIMIT 1
            ", ['table' => $table]);

            $geomColumn = $geomColumnRow ? $geomColumnRow->column_name : 'geom';

            // PostGIS query compiling entire dataset as a GeoJSON FeatureCollection
            $query = "
                SELECT jsonb_build_object(
                    'type', 'FeatureCollection',
                    'features', COALESCE(jsonb_agg(feature), '[]'::jsonb)
                ) AS geojson
                FROM (
                    SELECT jsonb_build_object(
                        'type', 'Feature',
                        'geometry', ST_AsGeoJSON(ST_Transform(\"{$geomColumn}\", 4326))::jsonb,
                        'properties', to_jsonb(inputs) - '{$geomColumn}'
                    ) AS feature
                    FROM \"{$table}\" inputs
                ) features
            ";

            $result = DB::connection('pgsql')->selectOne($query);

            return response($result->geojson)
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memproses data spasial.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
