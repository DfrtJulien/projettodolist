<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class UserController extends AbstractController
{
  public function index()
  {
    if (isset($_GET['id'])) {
      $userId = $_GET['id'];
      $user = new User($userId, null, null, null, null, null, null);
      $myUser = $user->getUserById();
      require_once(__DIR__ . '/../Views/profile.view.php');
    } else {
      $this->redirectToRoute('/');
    }
  }
}
