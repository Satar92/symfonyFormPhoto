<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

// use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    //#[Route('/admin/admin', name: 'app_admin_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


    public function addProduct(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // traitement de l'image envoyée
            $photo = $form->get('photo')->getData();
            // dd($photo);
            if($photo) {
                $originalFileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' .$photo->guessExtension();
            }

            try {
                $photo->move(
                    $this->getParameter('product_directory'), $newFileName
                );
            } catch (FileException $e){
                die();
            }

            $produit->setPhoto($newFileName);

            $db = $doctrine->getManager();
            $db->persist($produit);
            $db->flush();

            $this->addFlash('success', 'Le produit a été ajouté avec succès.');

            // return $this->redirectToRoute('app_add_product');
        }

        return $this->render('admin/add-product.html.twig', [
            'form' => $form->createView(),
        ]);
        }
    }

