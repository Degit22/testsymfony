<?php

namespace NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NewsBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", defaults={"page": 1}, name="news_list3")
     * @Route("/news/list/", defaults={"page": 1}, name="news_list")
     * @Route("/news/", defaults={"page": 1}, name="news_list2")
     * @Route("/news/list/page/{page}", requirements={"page": "[1-9]\d*"}, name="news_list_paginated")
     * @Template()
     */
    public function listAction($page) {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findLatest($page);

        $limit = Post::POSTS_ON_PAGE;
        $maxPages = ceil($posts->count() / $limit);
        $thisPage = $page;

        return $this->render('NewsBundle:Default:list.html.twig', compact('categories', 'maxPages', 'thisPage', 'posts'));
    }

    /**
    * @Route("/news/{name}", requirements={"name" = ".+"}, name="news_show")
    * @Template()
    */
    public function indexAction($name)
    {
        $post = $this->getDoctrine()->getRepository('NewsBundle:Post')->findOneByLink($name);

        if (!$post) {
            throw $this->createNotFoundException('Страница не найдена!');
        }

        return array('post' => $post);
    }
}
