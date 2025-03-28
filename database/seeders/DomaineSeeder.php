<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomaineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('domaines')->insert([
            "name"        => "Agriculture",
            "secteurs_id" => "1",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Élevage",
            "secteurs_id" => "1",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Énergie solaire",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Bâtiment et Travaux Publics (BTP)",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Agroalimentaire",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Aquaculture",
            "secteurs_id" => "1",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Hôtellerie",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Sciences agronomiques",
            "secteurs_id" => "1",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Pisciculture",
            "secteurs_id" => "1",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Artisanat",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Communication",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Chaudronnerie",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Chimie",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Commerce",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Numérique",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Informatique",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Restauration",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Couture",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Coiffure",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Mécanique",
            "secteurs_id" => "2",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Administration et Gestion",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Coiffure et Esthétique",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Hôtellerie et Restauration",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Services divers",
            "secteurs_id" => "3",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

        DB::table('domaines')->insert([
            "name"        => "Aucun",
            "secteurs_id" => "5",
            "created_at"  => now(),
            "updated_at"  => now(),
            "uuid"        => Str::uuid(),
        ]);

    }
}
