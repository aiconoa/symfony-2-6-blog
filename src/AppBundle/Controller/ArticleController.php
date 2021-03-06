<?php

namespace AppBundle\Controller;

use Aiconoa\StatisticsBundle\Entity\Visit;
use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/articles")
 */
class ArticleController extends Controller
{
    const NB_ARTICLE_PER_PAGE = 2;

    /**
     * @Route("/list")
     */
    public function listAction(Request $request)
    {
        $page = $request->get('page', '1');

        if(! ctype_digit($page)) {
            throw $this->createNotFoundException();
        }

        $page = (int) $page;

        if($page < 1) {
            throw $this->createNotFoundException();
        }

        $repository = $this->getDoctrine()->getRepository("AppBundle:Article");
        $totalArticles = $repository->count();
        $pageMax = ceil($totalArticles / ArticleController::NB_ARTICLE_PER_PAGE);

        if($page > $pageMax) {
            throw $this->createNotFoundException();
        }

        $offset = ($page - 1) * ArticleController::NB_ARTICLE_PER_PAGE;

        $articles = $repository->findAllWithOffsetAndLimitOrderedByCreatedOnDESC($offset,  ArticleController::NB_ARTICLE_PER_PAGE);


        //$articles = $this->buildFakeArticleList();
        //$articles = $this->getDoctrine()->getRepository("AppBundle:Article")->findAllOrderedByCreatedOnDESC();

        // :Article:list.html.twig
        return $this->render('Article/list.html.twig',
                            [
                                "articles"  => $articles,
                                "page"      => $page,
                                "pageMax"   => $pageMax
                            ]
            );
    }

     /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     */
    public function showAction($id, Request $request)
    {

        //$this->get('statService')->addVisit($request);

        // $article = $this->findFakeArticleById($id);
        $article = $this->getDoctrine()->getRepository("AppBundle:Article")->find($id);

        if($article === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('Article/show.html.twig',
            [
                "article" => $article
            ]
        );
    }

    /**
     * @Route("/create")
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        if($user == null) {
                throw $this->createAccessDeniedException();
        }

        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManagerForClass("AppBundle:Article");

            $article->setAuthor($user);
            $article->setCreatedOn(new \DateTime());
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article_list');
        }

        return $this->render('Article/create.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     */
    public function editAction(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository("AppBundle:Article")->find($id);

        if($article === null) {
            throw $this->createNotFoundException();
        }

        if (false === $this->get('security.authorization_checker')->isGranted('edit', $article)) {
            throw new AccessDeniedException('Unauthorised access!');
        }

        $form = $this->createForm(new ArticleType(), $article);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManagerForClass("AppBundle:Article");
            $em->merge($article);
            $em->flush();

            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('Article/edit.html.twig',
            [
                "form" => $form->createView(),
                "article" => $article
            ]
        );

    }

    /**
     * @Route("/article-links")
     */
    public function articleLinksAction()
    {
        $data = "[";

        $articles = $this->buildFakeArticleList();
        foreach($articles as $article) {
// rajouter , entre les elements json
            $s = "{'id' : " . $article->getId() . ", 'url': '" . $this->generateUrl("app_article_show", ["id" => $article->getId()]) . "'}";
            $data .= $s;
        }

        $data .= "]";

        return new Response($data, 200, ["Content-Type" => "application/json"]);
    }


    private function buildFakeArticleList()
    {
        $article1 = new Article();
        $article1->setId(0);
        $article1->setTitle("Le titre de mon premier article");
        $article1->setContent("Le contenu de mon premier article");
        $article1->setCreatedOn(new \DateTime());

        $article2 = new Article();
        $article2->setId(1);
        $article2->setTitle("Le titre de mon deuxième article");
        $article2->setContent("Le contenu de mon deuxième article");
        $article2->setCreatedOn(new \DateTime());

        $article3 = new Article();
        $article3->setId(2);
        $article3->setTitle("Le titre de mon troisième article");
        $article3->setContent("Le contenu de mon troisième article");
        $article3->setCreatedOn(new \DateTime());

        return [$article1, $article2, $article3];
    }
    private function findFakeArticleById($id) {
        $articles = $this->buildFakeArticleList();

        foreach($articles as $article) {
            if($article->getId() == $id) {
                return $article;
            }
        }

        return null;
    }
}
