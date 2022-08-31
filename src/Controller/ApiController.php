<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\User;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpClient\HttpClient;

class ApiController extends AbstractController
{
    #[Route('/api/quizz', name: 'app_api_question', methods: ['GET'])]
    public function questions(QuestionRepository $question): Response
    {
        $questions = $question->findAll();
        $response = $this->json($questions, 200, [], []);
 
        return $response;
        // $response = question et reponse accessible au format json
    }
    
// je veux recup les question/reponse au format json pour les utiliser dans react

// je veux pouvoir persister un quizz une fois qu'il est terminé

// je veux savoir comment gérer un systeme de connection avec react si c'est possible avec une api ?

// je veux récupérer le nom des images de mon résultat via l'api






    #[Route('/api/quizz/new', name: 'app_api_quizz', methods: ['POST'])]
    public function quizz(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
       //en appuyant sur faire le test on crée dans la bdd le quizz et on peut y afficher les question
        $jsonReceive = $request->getContent();

      
        try {
            $quizz = $serializer->deserialize($jsonReceive, Quizz::class, 'json');
    
            $entityManager->persist($quizz);
            $entityManager->flush();
            dd($this->json($quizz, 201, [], []));
            
            return $this->json($quizz, 201, [], []);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status'=> 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
