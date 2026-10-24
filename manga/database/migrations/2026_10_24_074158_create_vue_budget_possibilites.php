<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vue_budget_possibilites AS
            SELECT
                p.id AS projet_id,
                pp.id AS possibilite_id,
                p.user_id,
                p.budget,

                COALESCE(
                    SUM(
                        CASE
                            WHEN ep.selectionne = 1
                            THEN ep.prix * ep.quantite
                            ELSE 0
                        END
                    ),
                    0
                ) AS total_depenses,

                p.budget - COALESCE(
                    SUM(
                        CASE
                            WHEN ep.selectionne = 1
                            THEN ep.prix * ep.quantite
                            ELSE 0
                        END
                    ),
                    0
                ) AS reste,

                ROUND(
                    (
                        COALESCE(
                            SUM(
                                CASE
                                    WHEN ep.selectionne = 1
                                    THEN ep.prix * ep.quantite
                                    ELSE 0
                                END
                            ),
                            0
                        ) / NULLIF(p.budget, 0)
                    ) * 100,
                    1
                ) AS pourcentage_budget,

                CASE
                    WHEN COALESCE(
                        SUM(
                            CASE
                                WHEN ep.selectionne = 1
                                THEN ep.prix * ep.quantite
                                ELSE 0
                            END
                        ),
                        0
                    ) > p.budget
                    THEN 1
                    ELSE 0
                END AS hors_budget

            FROM projets p

            INNER JOIN possibilite_projets pp
                ON pp.projet_id = p.id

            LEFT JOIN categorie_projets cp
                ON cp.possibilite_projet_id = pp.id

            LEFT JOIN element_projets ep
                ON ep.categorie_projet_id = cp.id

            GROUP BY
                p.id,
                pp.id,
                p.user_id,
                p.budget
        ");
    }

    public function down(): void
    {
        DB::statement("
            DROP VIEW IF EXISTS vue_budget_possibilites
        ");
    }
};