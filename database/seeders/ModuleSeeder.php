<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* DB::table('modules')->insert([
            "name"=>"Autre",
            "domaines_id"=>"1",
            'created_at' => now(),
            'updated_at' => now(),
            "uuid"=>Str::uuid(),
        ]); */

        DB::table('modules')->insert([
            "name"                 => "Maraîchage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier maraîcher",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Agriculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technique agricole",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien agricole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de bonne pratique agricole",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, ouvrier qualifié",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Arboriculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier arboricole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Apiculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier apicole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production maraîchère",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier maraîcher",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Fabrication de matériels agricoles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en fabrication de machines agricoles",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Machinisme agricole",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, technicien en machinisme agricole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Installation de système de pompage solaire pour irrigation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien ouvrier en énergie solaire photovoltaïque",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Installation de réseau d’irrigation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Installation de sanitaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et conservation de produits agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent en transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion des infrastructures et productions aquacoles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, gestionnaire d'exploitation aquacole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production de viande et de lait",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Productions horticoles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Producteur horticole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production de semences et de pépinières",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent producteur de semences et de pépinières",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maintenance des équipements de transformation agroalimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en maintenance",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Élevage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de production, agent, technicien d’embouche",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Embouche porcine",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en embouche porcine",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques d’élevage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, agent d’élevage",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Producteur d’élevage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des fruits et légumes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des produits agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Management de la sécurité des denrées alimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des produits halieutiques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de produits carnés",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des produits locaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de produits agricoles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, technicien en transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de céréales et légumineuses",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technique de productions alimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de production agroalimentaire",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation fruits et légumes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation produits laitiers",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et conservation des produits d’anacarde",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et conservation des céréales locales",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et conservation des fruits et légumes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des céréales locales",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Arts culinaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Cuisinier, aide cuisinier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation produits locaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Agroalimentaire et entreprenariat agricole",
            "domaines_id"          => "1",
            "niveau_qualification" => "Gestionnaire de TPE",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de transformation alimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des produits laitiers",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de céréales locales",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent en transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Sciences agronomiques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et conservation des produits locaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation et de conservation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conduite d'équipements de production",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, conducteur de ligne de production",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Étude de marché pour produits agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Lancement produits et référencement",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable marketing",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Emballage et packaging de produits agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable marketing",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Création de marque",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable marketing",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Formulaire nouveau produit",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable marketing",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "ISO 22000",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable qualité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "HACCP",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable qualité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Hygiène et sécurité alimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable qualité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technologie alimentaire boisson et jus",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de production de jus et boisson",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technologie alimentaire céréales",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technologie alimentaire produits laitiers",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technologie alimentaire fruits et légumes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Agroalimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des produits agricoles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Opérateur, agent en transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technologie agroalimentaire et normalisation internationale",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Labélisation des produits agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technique de valorisation des déchets agroalimentaires, agro écologie et norme organique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Étude et suivi de projet agroalimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de gestion contamination des industries agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Analyses agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien laboratoire agroalimentaire",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Inspection et contrôle hygiène alimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable QHSE",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Inspection conformité des normes de construction unité de transformation agroalimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable QHSE",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Norme de production et contrôle qualité en agroalimentaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, responsable QHSE",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Management, gestion des sociétés agroalimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Cadre et technicien assimilés",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Nouvelle technologie de transformation agroalimentaire et norme de qualité",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Hygiène et qualité des denrées alimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Opérateur hygiène, responsable qualité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation des denrées alimentaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de transformation de produits alimentaires",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production piscicole",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier piscicole/aquacole, technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Aquaculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, technicien aquacole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Pisciculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, technicien piscicole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Artisanat",
            "domaines_id"          => "1",
            "niveau_qualification" => "Maîtres artisans",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de production de matériaux innovants en artisanat",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier qualifié",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Audiovisuel",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien audiovisuel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production audiovisuelle (multimédia)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien audiovisuel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Bâtiment et Travaux publics",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, technicien en construction de bâtiments et travaux publics",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Levage et manutention",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de manutention, agent de levage",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conduite d'engins",
            "domaines_id"          => "1",
            "niveau_qualification" => "Grutier, cariste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Topographie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier qualifié",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Installation de panneaux solaires photovoltaïques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien ouvrier qualifié",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Géologue prospecteur",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation et valorisation du typha et des fibres naturelles en construction durable",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier qualifié",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité bâtiment",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité solaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Plomberie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Plombier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maintenance engins",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, agent de maintenance d'engins",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conducteur d’engins (chargeuse, pelle hydraulique, camion, bulldozer, niveleuse, etc.)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Conducteur d’engins",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Ferraillage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technique de pose de pavés",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Coffrage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier coffreur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Staff plâtres",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier plâtre",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Carrelage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier carreleur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Plomberie sanitaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier plombier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité basse tension",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Schéma électrique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Câblage électrique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Chaudronnerie tuyauterie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chaudronnier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Menuiserie acier",
            "domaines_id"          => "1",
            "niveau_qualification" => "Menuisier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Pavage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Paveur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Dessin assisté par ordinateur",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en DAO",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Dessin bâtiment",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien, dessinateur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maçonnerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Maçon",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électro bobinage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien industriel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité solaire photovoltaïque",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien en énergie solaire",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité domestique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien domestique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Chaudronnerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Teinture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier teinturier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Sérigraphie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Sérigraphe",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Saponification",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en saponification, ouvrier fabrication de production de savon",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Teinture batik",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier, teinturier batik",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Javellisation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier javellisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Teinture sérigraphie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Teinturier sérigraphe",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Saponification, javellisation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en saponification et javellisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Production de savon liquide",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Savonnerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, ouvrier en saponification",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de vente",
            "domaines_id"          => "1",
            "niveau_qualification" => "Commercial, technico-commercial, ingénieur commercial",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Technique de communication",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent, technicien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conduite de changement, pilotage de la performance",
            "domaines_id"          => "1",
            "niveau_qualification" => "Manager",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Infographie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Infographe",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maintenance informatique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en maintenance informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Réseaux informatiques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien réseaux",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Administration système",
            "domaines_id"          => "1",
            "niveau_qualification" => "Administrateur système",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Data Science",
            "domaines_id"          => "1",
            "niveau_qualification" => "Data Scientist, analyste de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Intelligence artificielle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en intelligence artificielle",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Cloud computing",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur cloud, technicien cloud",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Virtualisation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur, technicien en virtualisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de bases de données",
            "domaines_id"          => "1",
            "niveau_qualification" => "Administrateur de bases de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Communication digitale",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chargé de communication digitale",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Analyse de données (Power BI, Tableau)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Analyste de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Robotique et objets connectés (IoT)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Spécialiste en IoT",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de la cybersécurité",
            "domaines_id"          => "1",
            "niveau_qualification" => "Expert en cybersécurité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Formation en compétences numériques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Formateur en numérique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Consultant en transformation digitale",
            "domaines_id"          => "1",
            "niveau_qualification" => "Consultant digital",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Bureautique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Opérateur bureautique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développement web",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur web",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développement d'applications mobiles",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur d'applications mobiles",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développement back-end et front-end",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur back-end, développeur front-end",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développement de jeux vidéo",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur de jeux vidéo",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Analyse de données (Big Data)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Data Scientist, analyste de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Machine Learning et intelligence artificielle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en intelligence artificielle",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Visualisation de données (Power BI, Tableau)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Analyste de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Sécurité des systèmes d'information",
            "domaines_id"          => "1",
            "niveau_qualification" => "Expert en cybersécurité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion des risques informatiques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Consultant en cybersécurité",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Audit de sécurité",
            "domaines_id"          => "1",
            "niveau_qualification" => "Auditeur en sécurité informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de services cloud (AWS, Azure, Google Cloud)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur cloud, architecte cloud",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Virtualisation et conteneurs (Docker, Kubernetes)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en virtualisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développement d'applications IoT",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur IoT",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de réseaux IoT",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en réseaux IoT",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Marketing digital",
            "domaines_id"          => "1",
            "niveau_qualification" => "Community manager, responsable marketing digital",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de médias sociaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Social media manager",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conception de sites web",
            "domaines_id"          => "1",
            "niveau_qualification" => "Concepteur web, UX/UI designer",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conseil en transformation digitale",
            "domaines_id"          => "1",
            "niveau_qualification" => "Consultant en transformation digitale",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de projets numériques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chef de projet numérique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Programmation de robots",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en robotique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Automatisation industrielle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en automatisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Programmation orientée objet (Java, C++, Python)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur logiciel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Programmation web (HTML, CSS, JavaScript)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur web",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Administration de réseaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Administrateur réseaux",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Sécurité des réseaux",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en sécurité réseaux",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de bases de données (SQL, NoSQL)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Administrateur de bases de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Data Mining",
            "domaines_id"          => "1",
            "niveau_qualification" => "Analyste de données",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Administration de systèmes (Windows, Linux)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Administrateur système",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Virtualisation de systèmes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en virtualisation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conception de logiciels",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur logiciel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Tests et validation de logiciels",
            "domaines_id"          => "1",
            "niveau_qualification" => "Testeur logiciel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maintenance matérielle et logicielle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en maintenance informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Support technique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien support informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Cryptographie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Expert en cryptographie",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion des incidents de sécurité",
            "domaines_id"          => "1",
            "niveau_qualification" => "Analyste en sécurité informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Traitement du langage naturel (NLP)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en intelligence artificielle",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Vision par ordinateur",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ingénieur en vision par ordinateur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de projets Agile",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chef de projet informatique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion de projets avec Scrum",
            "domaines_id"          => "1",
            "niveau_qualification" => "Scrum Master",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Restauration",
            "domaines_id"          => "1",
            "niveau_qualification" => "Cuisinier, aide-cuisinier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Hébergement",
            "domaines_id"          => "1",
            "niveau_qualification" => "Réceptionniste, concierge",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Événementiel",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chef de projet événementiel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Management hôtelier",
            "domaines_id"          => "1",
            "niveau_qualification" => "Directeur d'hôtel, manager hôtelier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Cuisine",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chef de cuisine, commis de cuisine",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Service en salle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Serveur, maître d'hôtel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Pâtisserie et boulangerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Pâtissier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Management de la restauration",
            "domaines_id"          => "1",
            "niveau_qualification" => "Gérant de restaurant",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Restauration collective",
            "domaines_id"          => "1",
            "niveau_qualification" => "Cuisinier en restauration collective",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Confection",
            "domaines_id"          => "1",
            "niveau_qualification" => "Couturier, couturière",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Stylisme",
            "domaines_id"          => "1",
            "niveau_qualification" => "Styliste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Retouches",
            "domaines_id"          => "1",
            "niveau_qualification" => "Retoucheur, retoucheuse",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maroquinerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Maroquinier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Coiffure générale",
            "domaines_id"          => "1",
            "niveau_qualification" => "Coiffeur, coiffeuse",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Coiffure événementielle",
            "domaines_id"          => "1",
            "niveau_qualification" => "Coiffeur événementiel",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Soins capillaires",
            "domaines_id"          => "1",
            "niveau_qualification" => "Spécialiste en soins capillaires",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Barbier",
            "domaines_id"          => "1",
            "niveau_qualification" => "Barbier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Formation",
            "domaines_id"          => "1",
            "niveau_qualification" => "Formateur en coiffure",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Vente et conseil",
            "domaines_id"          => "1",
            "niveau_qualification" => "Conseiller en produits capillaires",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Conduite d'engins de TP (Tracteurs, moissonneuses…)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Conducteur d'engins",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Techniques de pose de pavés",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en pose de pavés",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Plomberie (Installations sanitaires)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Plombier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Electricité",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Bétonnage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en bétonnage",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Peinture bâtiment",
            "domaines_id"          => "1",
            "niveau_qualification" => "Peintre en bâtiment",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maçonnerie et Bétonnage",
            "domaines_id"          => "1",
            "niveau_qualification" => "Maçon",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Entretien routier (route et ouvrage)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier en entretien routier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Électricité et entretien de l'éclairage public solaire",
            "domaines_id"          => "1",
            "niveau_qualification" => "Électricien spécialisé en énergie solaire",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Mécanique (entretien et réparation de matériels agricoles)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Mécanicien agricole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Graisseur",
            "domaines_id"          => "1",
            "niveau_qualification" => "Graisseur",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Pompiste",
            "domaines_id"          => "1",
            "niveau_qualification" => "Pompiste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de fruits et légumes",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation de céréales locales (étuvage et décorticage du riz)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Technicien en transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation, conditionnement et conservation des produits laitiers",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Transformation, conditionnement et conservation des produits halieutiques",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de transformation",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Maraîchage (par système d'aspersion goutte à goutte)",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier maraîcher",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Aviculture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Ouvrier avicole",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Embouche ovine",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent en embouche",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Assistanat de direction",
            "domaines_id"          => "1",
            "niveau_qualification" => "Assistant de direction",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Gestion administrative",
            "domaines_id"          => "1",
            "niveau_qualification" => "Gestionnaire administratif",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Secrétariat",
            "domaines_id"          => "1",
            "niveau_qualification" => "Secrétaire",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Accueil",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent d'accueil",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Manager de station",
            "domaines_id"          => "1",
            "niveau_qualification" => "Manager de station",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Chef de boutique",
            "domaines_id"          => "1",
            "niveau_qualification" => "Chef de boutique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Caissier",
            "domaines_id"          => "1",
            "niveau_qualification" => "Caissier",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Rayonniste",
            "domaines_id"          => "1",
            "niveau_qualification" => "Rayonniste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Coiffure",
            "domaines_id"          => "1",
            "niveau_qualification" => "Coiffeur, coiffeuse",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Développeur back-end",
            "domaines_id"          => "1",
            "niveau_qualification" => "Développeur back-end",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Restauration",
            "domaines_id"          => "1",
            "niveau_qualification" => "Serveur, cuisinier, réceptionniste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Tourisme",
            "domaines_id"          => "1",
            "niveau_qualification" => "Serveur, cuisinier, réceptionniste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Hôtellerie",
            "domaines_id"          => "1",
            "niveau_qualification" => "Serveur, cuisinier, réceptionniste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Guide Tourisme",
            "domaines_id"          => "1",
            "niveau_qualification" => "Guide touristique",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Hôtellerie-Cuisine-Restauration",
            "domaines_id"          => "1",
            "niveau_qualification" => "Cuisinier, serveur, réceptionniste",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Coupe-Couture",
            "domaines_id"          => "1",
            "niveau_qualification" => "Couturier, couturière",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

        DB::table('modules')->insert([
            "name"                 => "Laveur",
            "domaines_id"          => "1",
            "niveau_qualification" => "Agent de nettoyage",
            'created_at'           => now(),
            'updated_at'           => now(),
            "uuid"                 => Str::uuid(),
        ]);

    }
}
