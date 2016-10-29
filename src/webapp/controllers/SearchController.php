<?php

namespace tdt4237\webapp\controllers;

use tdt4237\webapp\models\Patent;

class SearchController extends Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function searchForCompany($company)
    {
    	$patents = $this->searchRepository->searchForCompany($company);
    }

    public function searchForTitle($title)
    {
    	$patents = $this->searchRepository->searchForTitle($title);
    }
	//TRENGER EN INDEKS - funksjon
    //er dette den som laster alle patenter opp?
    //trenger jeg flere use for å få dette til å funke? 

    public function index()
    {
        $patent = $this->patentRepository->all();
        if($patent != null)
        {
            $patent->sortByDate();
        }
        $users = $this->userRepository->all();
        $this->render('search.twig', ['patent' => $patent, 'users' => $users]);
    }


}
