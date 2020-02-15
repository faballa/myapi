<?php

namespace App\DataPersister;

use App\Entity\Compte;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CompteDataPersister implements DataPersisterInterface
 {
    public function __construct(EntityManagerInterface $entitymanager,ContratRepository $repo)
    {
        $this->entityManager = $entitymanager;
        $this->repo=$repo;
    }
    public function supports($data): bool
    {
        return $data instanceof Compte;
        // TODO: Implement supports() method.
    }
   public function persist($data)
   {
  
      
       $this->entityManager->persist($data);
       $this->entityManager->flush();
       $contrat1=$this->repo->findAll();
       $contrat=array(
        "numero de compte"=>$data->getNumCompte(),
        "createur de compte"=>$data->getUserCreateur()->getUserCreateur(),
        "date contrat"=>$data->getDateCreation(),
        "les Articles"=> $contrat1->getTermes()
    );
return new JsonResponse($contrat);

   }
   public function remove($data)
   {
    $this->entityManager->remove($data);
    $this->entityManager->flush();
       // TODO: Implement remove() method.
   }

 }
