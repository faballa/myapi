<?php
namespace App\Controller;

use App\Entity\Transaction;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionController
{
    private $tokenStorage;

   /* public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
   *//*  public function __invoke(Transaction $data): Transaction
    { */
       # $user=$this->tokenStorage->getToken->getUser();
        #$compte=$user->getAffectationUser()[0]->getCompte();
       /* echo "<pre>";
        var_dump($data);
        echo "</pre>";*/
  /*       
   dd($data);

        return $data;
    } */
}