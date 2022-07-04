<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{
    /**
     * @Route("/vue/{id}", name="vue")
     */
    public function vue(CategoryRepository $repo,$id): Response
    {
        $oneVue= $repo->find($id);
        return $this->render('crud/vue.html.twig', [
            'repo' =>$oneVue
        ]);
    }

    /**
     * @Route("/maj/{id}", name="maj", methods="GET | POST")
     *
     * @return void
     */
    public function maj(Category $categ, Request $requete){
        $form=$this->createForm(CategoryType::class, $categ);
        $form->handleRequest($requete);

        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('home/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     *
     * @param Category $categ
     * @param Request $requete
     * @return void
     */
    public function delete(Category $categ, Request $requete){

         $em= $this->getDoctrine()->getManager();
         $em->remove($categ);
         $em->flush();
         return $this->redirectToRoute("home");
    
    }
}
