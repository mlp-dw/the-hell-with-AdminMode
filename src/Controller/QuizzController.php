<?php

namespace App\Controller;


use App\Entity\Quizz;
use App\Form\QuizzType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quizz')]
class QuizzController extends AbstractController
{

    #[Route('/couleur', name: 'app_quizz_color', methods: ['GET', 'POST'])]
    public function selectColor(QuestionRepository $question, AnswerRepository $answer): Response
    {
        $fisrtQuestion = $question->findOneBy(["id" => 1]) ;
        $answers = $answer->findBy(["question" => $fisrtQuestion]);

        return $this->render('quizz/question1.html.twig', [
            'question' => $fisrtQuestion,
            'answers' => $answers,
        ]);
    }

    #[Route('/type', name: 'app_quizz_type', methods: ['GET', 'POST'])]
    public function selectType(Request $request, QuestionRepository $question, AnswerRepository $answer): Response
    {
        $secondQuestion = $question->findOneBy(["id" => 2]) ;
        $answers = $answer->findBy(["question" => $secondQuestion]);

        $answer1 = $request->request->get('answer1');

        return $this->render('quizz/question2.html.twig', [
            'question' => $secondQuestion,
            'answers' => $answers,
            'answer1' => $answer1
        ]);
    }

    #[Route('/longueur', name: 'app_quizz_length', methods: ['GET', 'POST'])]
    public function selectLength(Request $request, QuestionRepository $question, AnswerRepository $answer): Response
    {
        $thirdQuestion = $question->findOneBy(["id" => 3]) ;
        $answers = $answer->findBy(["question" => $thirdQuestion]);

        $answer1 = $request->request->get('answer1');
        $answer2 = $request->request->get('answer2');
        
        return $this->render('quizz/question3.html.twig', [
            'question' => $thirdQuestion,
            'answers' => $answers,
            'answer1' => $answer1,
            'answer2' => $answer2,
        ]);
    }

    #[Route('/matiere', name: 'app_quizz_texture', methods: ['GET', 'POST'])]
    public function selectTexture(Request $request, QuestionRepository $question, AnswerRepository $answer): Response
    {
        $forthQuestion = $question->findOneBy(["id" => 4]) ;
        $answers = $answer->findBy(["question" => $forthQuestion]);

        $answer1 = $request->request->get('answer1');
        $answer2 = $request->request->get('answer2');
        $answer3 = $request->request->get('answer3');

        return $this->render('quizz/question4.html.twig', [
            'question' => $forthQuestion,
            'answers' => $answers,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
        ]);
    }

    #[Route('/theme', name: 'app_quizz_theme', methods: ['GET', 'POST'])]
    public function selectTheme(Request $request, QuestionRepository $question, AnswerRepository $answer): Response
    {
        $fifthQuestion = $question->findOneBy(["id" => 5]) ;
        $answers = $answer->findBy(["question" => $fifthQuestion]);

        $answer1 = $request->request->get('answer1');
        $answer2 = $request->request->get('answer2');
        $answer3 = $request->request->get('answer3');
        $answer4 = $request->request->get('answer4');

        return $this->render('quizz/question5.html.twig', [
            'question' => $fifthQuestion,
            'answers' => $answers,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
            'answer4' => $answer4,
        ]);
    }

    #[Route('/result', name: 'app_quizz_result', methods: ['GET', 'POST'])]
    public function result(Request $request, QuizzRepository $quizzRepository): Response
    {
        $answer1 = $request->request->get('answer1');
        $answer2 = $request->request->get('answer2');
        $answer3 = $request->request->get('answer3');
        $answer4 = $request->request->get('answer4');
        $answer5 = $request->request->get('answer5');

        $user = $this->getUser();

        if($user){
            $quizz = new Quizz();
            $quizz->setUser($user);
            $quizz->setResult($answer1 . " " . $answer2 . " " . $answer3 . " " . $answer4 . " " . $answer5 . ".png");
    
            $quizzRepository->add($quizz, true);
        }

        return $this->render('quizz/result.html.twig', [
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
            'answer4' => $answer4,
            'answer5' => $answer5,
        ]);
    }

    #[Route('/{id}', name: 'app_quizz_delete', methods: ['POST'])]
    public function delete(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quizz->getId(), $request->request->get('_token'))) {
            $quizzRepository->remove($quizz, true);
        }
        return $this->redirectToRoute('app_modeles', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/{id}/edit', name: 'app_quizz_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    // {
    //     $form = $this->createForm(QuizzType::class, $quizz);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $quizzRepository->add($quizz, true);

    //         return $this->redirectToRoute('app_quizz_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('quizz/edit.html.twig', [
    //         'quizz' => $quizz,
    //         'form' => $form,
    //     ]);
    // }

    
}
