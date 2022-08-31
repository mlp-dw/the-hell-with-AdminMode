<?php

namespace App\Controller;

use App\Entity\Testimonial;
use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        $testimonials = $testimonialRepository->findAll();
        return $this->render('home/index.html.twig', [
            'testimonials' => $testimonials,
        ]);
    }
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(): Response
    {
        return $this->render('gallery/index.html.twig');
    }
    #[Route('/launch', name: 'app_launch')]
    public function launch(): Response
    {
        return $this->render('launch/index.html.twig');
    }
}
