<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(CategoryRepository $repo,UserRepository $user): Response
    {
        // $category= new Category();
        // $category1=new Category();
        // $category->setReference('RA10')
        // ->setNomcategorie('bolo')
        // ->setPrix(1000);

        // $category1->setReference('So101')
        // ->setNomcategorie('chips')
        // ->setPrix(200);
        // $em=$this->getDoctrine()->getManager();
        // $em->persist($category);
        // $em->persist($category1);
        // $em->flush();
        
        $category= $repo->findAll();
        //$use=$user->find();
        return $this->render('home/index.html.twig',[
        'category'=>$category
      
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     *
     * @return void
     */
    public function ajout(Request $requete){
       
        $categ= new Category();
        $form=$this->createForm(CategoryType::class,$categ);
        $form->handleRequest($requete);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($categ);
            $em->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('home/create.html.twig',[
            'form'=>$form->createView()
        ]);
        
    }
}
