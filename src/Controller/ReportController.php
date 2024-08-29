<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends AbstractController
{
    #[Route('/admin/report', name: 'app_report')]
    public function index(
        BookRepository $bookRepository,
        EntityManagerInterface $em
    ): Response
    {
        $sql = "SELECT * FROM author_books_subjects AS report_view ORDER BY author_name ASC";
        
        $stmt = $em->getConnection()->prepare($sql);
        $reportData = $stmt->executeQuery()->fetchAllAssociative();

        return $this->render('report/index.html.twig', [
            'reportData' => $reportData
        ]);
    }
}
