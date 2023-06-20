<?php

namespace App\Service;

use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;

class AppHelpers
{
    private $db;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function installBDD(): void
    {
        // recuperation des catégories dans la table Categorie
        $categories = $this->db->getRepository(Categorie::class)->findAll();
        // si pas de cat trouvée en BDD on installe celles
        // du tableau retourné par getCategorieList()
        if (!count($categories)) {
            $this->installCategories();
        }
    }
    private function installCategories(): void
    {
        $catList = $this->getCategoryList();
        foreach ($catList as $cat) {
            $category = new Categorie();
            $category->setNom($cat['nom']);
            $this->db->persist($category);
        }
        $this->db->flush();
    }

    private function getCategoryList(): array
    {
        return [
            [
                "nom" => "t-shirt",
            ],
            [
                "nom" => "chemise",
            ],
            [
                "nom" => "pull",
            ],
        ];
    }
}
