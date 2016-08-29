<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/",name="app_default_index" )
     * @Template
     */
    public function indexAction(Request $request) {
    
        
      $users=$this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        
        return ["users"=>$users];
    }
 /**
     * @Route("/add",name="app_default_add" )
     * @Template
     */
    public function addAction(Request $request, $name = "ali ahmadi") {
     
       $form=$this->createFormBuilder(new \AppBundle\Entity\User)
                ->add("firstname", null, ['label'=>'name'])
                ->add("lastname",null,['label'=>'family'] )
                ->add("email")
                ->add("password" , PasswordType::class)
                ->add("submit", SubmitType::class)
                   ->getform()
                ;
        $form->handleRequest($request);
        if($form->isValid()){
        $data=$form->getData();
        
      $em=$this->getDoctrine()->getManager();
      $em->persist($data);
      $em->flush();
      
      return $this->redirectToRoute("app_default_add");
      
        }
        
        
        return ["messege" => "hello" . $name ,"myform"=>$form->createView()];
    }
     /**
     * @Route("/edit/{id}",name="app_default_edit" )
     * @ParamConverter("user",class="AppBundle:User")
     * @Template
     */
    public function editAction(Request $request, $user) {
     
       $form=$this->createFormBuilder($user)
                ->add("firstname", null, ['label'=>'name'])
                ->add("lastname",null,['label'=>'family'] )
                ->add("email")
                ->add("password" , PasswordType::class)
                ->add("submit", SubmitType::class)
                   ->getform()
                ;
        $form->handleRequest($request);
        if($form->isValid()){
        $data=$form->getData();  
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        }
        
        
        return ["myform"=>$form->createView()];
    }
}
