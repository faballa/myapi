<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Contrat;
use App\Entity\Partenaire;
use App\Repository\RoleRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CompteController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        
    }
    /**
     * @Route("api/new/compte", name="new_compte",  methods={"POST"})
     */
    public function newCompte(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncode,RoleRepository $roleRepository,PartenaireRepository $partenaireRepository)
    {
        $values = json_decode($request->getContent());
       
        $dateJours = new \DateTime();
        $user = new User();
        $depot = new Depot();
        $compte = new Compte();
        $role = $roleRepository->findOneBy(array('libelle' => 'PARTENAIRE'));
        $partenaire_existant = $partenaireRepository->findOneBy(array('ninea' => $values->ninea));
        
        if($values){
            #### Creation de User Partenaire ####
            if($partenaire_existant != null){

                #### Générer le numéro de compte #####

                $compte_id = $this->getLastId() + 1 ;
                $numCompte =str_pad($compte_id, 9 ,"0",STR_PAD_LEFT);
                
                #### Creation de compte Partenaire ####

                $userCreateur = $this->tokenStorage->getToken()->getUser();
             
                $compte->setNumCompte($numCompte)
                    ->setSolde(0)
                    ->setDatecreation($dateJours)
                    ->setUserCreateur($userCreateur)
                    ->setPartenairesC($partenaire_existant);
                $manager->persist($compte);
                
                ##### Initiliasation du compte ####

                $depot->setDateDepot($dateJours)
                    ->setSolde($values->solde)
                    ->setUsersCreateurd($userCreateur)
                    ->setCompte($compte);
                $manager->persist($depot);

                #### Mise à jour du compte #####

                $NouveauSolde = ($values->solde+$compte->getSolde());
                $compte->setSolde($NouveauSolde);
                $manager->persist($compte);
                $manager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Ce partenaire existe déja et un nouveau compte a été bien creé pour lui . '
                ];
                return new JsonResponse($data, 201);

            }else{
                $partenaire = new Partenaire();
                #### Creation de  Partenaire ####
        
                $partenaire->setNinea($values->ninea)
                    ->setRegiecommerce($values->regiecommerce);
                $manager->persist($partenaire);


                $user->setUsername($values->username)
                    ->setPassword($passwordEncode->encodePassword($user, $values->password))
                    ->setRole($role)
                    ->setAdresse($values->adresse)
                    ->setTelephone($values->telephone)
                    ->setPartenaire($partenaire);
                $manager->persist($user);

                #### Générer le numéro de compte #####

                $compte_id = $this->getLastId() + 1 ;
                $numCompte =str_pad($compte_id, 9 ,"0",STR_PAD_LEFT);
                
                #### Creation de compte Partenaire ####

                $userCreateur = $this->tokenStorage->getToken()->getUser();
                $compte->setNumCompte($numCompte)
                    ->setSolde(0)
                    ->setDatecreation($dateJours)
                    ->setUserCreateur($userCreateur)
                    ->setPartenairesC($partenaire);
                $manager->persist($compte);
                
                ##### Initiliasation du compte ####

                $depot->setDateDepot($dateJours)
                    ->setSolde($values->solde)
                    ->setUsersCreateurd($userCreateur)
                    ->setCompte($compte);
                $manager->persist($depot);

                #### Mise à jour du compte #####

                $NouveauSolde = ($values->solde+$compte->getSolde());
                $compte->setSolde($NouveauSolde);
                $manager->persist($compte);
                $manager->flush();
                $data = [
                    'status' => 201,
                    'message' => 'Le compte a été bien creé . '
                ];
                return new JsonResponse($data, 201);
            
            }
        }else{
            $data = [
                'status' => 500,
                'message' => 'Veuillez saisir les valeurs . '];
    
            return new JsonResponse($data, 500);
        }
                    
    }

    ### Get last Partenaire ###
    public function getLastId() 
    {
        $repository = $this->getDoctrine()->getRepository(Compte::class);
        // look for a single Product by name
        $res = $repository->findBy([], ['id' => 'DESC']) ;
        if($res == null){
            return 0;
        }else{
            return $res[0]->getId();
        }
        
    }  
}