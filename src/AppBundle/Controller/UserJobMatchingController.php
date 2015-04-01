<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserJobMatchingController extends Controller
{

    /**
     * @Route("cron/match-new-jobs-for-all-users")
     */
    public function matchNewJobsForallUsers()
    {
        // 1 recuperer la liste des users
        // 2 pour chaque user appeler matchNewJobsForUser
    }

    public function matchNewJobsForUser($idUser)
    {
        /*
         *  1) consolider dans une table tous les jobs a envoyer a un utilisateur donné:
         *  - qui n'ont pas deja ete proposes a l'utilisateur  : table "already sent in the past" userId | jobId | sentOn
         *  - ceux qui matchent avec les criteres de l'utilisateur: competences, localisation,...
         *
         *  => inscrire dans une table "jobs to send to user => userId | jobId
         *
         * 2) imaginons on veut envoyer des maintenant les jobs
         *  => faire une transaction car
         * - il faut envoyer un email avec les offres "a envoyer"
         * - il faut deplacer les jobs de la table "a envoyer" vers la table "already sent in the past"
         *
         */

    }

}
