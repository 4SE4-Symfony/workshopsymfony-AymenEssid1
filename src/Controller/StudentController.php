<?php

namespace App\Controller;

use App\Form\SearchStudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use App\Form\StudentType;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/addStudent', name: 'app_addStudent')]
    public function addStudent(Request $request,ManagerRegistry $doctrine){
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("list_classroom");
        }
        return $this->renderForm("student/add.html.twig",array("formStudent"=>$form));
    }

    #[Route('/listStudent', name: 'app_listStudent')]
    public function listStudent(Request $request,StudentRepository  $repository)
    {
        $students= $repository->findAll();
        $studentsByNCE= $repository->sortByNCE();
        $formSearch= $this->createForm(SearchStudentType::class);
        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted()){
            $nce= $formSearch->get('nce')->getData();
            $result= $repository->searchStudent($nce);
            return $this->renderForm("student/list.html.twig",array(
                'studentsList'=>$result,
                'studentsByNCE'=>$studentsByNCE,
                'formSearch'=>$formSearch
            ));
        }
        return $this->renderForm("student/list.html.twig",array(
            'studentsList'=>$students,
            'studentsByNCE'=>$studentsByNCE,
            'formSearch'=>$formSearch

        ));
    }

}
