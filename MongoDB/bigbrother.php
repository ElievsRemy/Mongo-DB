<?php

if (!isset($argv[2]))
{
  echo "[Usage]: [Option] [Login].";
}
else
{
  if ($argv[1] == "add_student")
     add_stud($argv[2]);
  else if ($argv[1] == "del_student")
     del_stud($argv[2]);
  else if ($argv[1] == "update_student")
     update_stud($argv[2]);
  else if ($argv[1] == "show_student")
     show_stud($argv[2]);
  else if ($argv[1] == "add_comment")
     add_comment("argv[2]");
}

function	connection()
{
  $connect = new MongoClient();
  echo "Connection to database successfully\n";
  $db = $connect->mydb;
  echo "Database: mydb selected\n";
  $collection = $db->student;
  echo "Collection: student selected\n";
}

function        del_stud($login)
{
  echo "Etes vous sur ?\n: ";
  $todel = fopen('php://stdin', 'r');
  $todel = fgets($todel);
  if ($todel == "oui\n")
    {
      $connect = new MongoClient();
      echo "Connection to database successfully\n";
      $db = $connect->mydb;
      echo "Database: mydb selected\n";
      $collection = $db->student;
      echo "Collection: student selected\n";      
      $collection->remove(array("_id" => $login));
      echo "Utilisateur Supprime !";
    }
}

function	add_stud($login)
{
  $connect = new MongoClient();
  echo "Connection to database successfully\n";
  $db = $connect->mydb;
  echo "Database: mydb selected\n";
  $collection = $db->student;
  echo "Collection: student selected\n";  
  echo "Nom\n: ";
  $name = fopen('php://stdin', 'r');
  $name = fgets($name);
  $name = trim($name, "\n");
  echo "Promo\n: ";
  $promo = fopen('php://stdin', 'r');
  $promo = fgets($promo);
  $promo = trim($promo, "\n");
  echo "Email\n: ";
  $email = fopen('php://stdin', 'r');
  $email = fgets($email);
  $email = trim($email, "\n");
  echo "Telephone\n:";
  $tel = fopen('php://stdin', 'r');
  $tel = fgets($tel);
  $tel = trim($tel, "\n");
  $addtab = array("_id" => $login, "nom" => $name, "promo" => $promo, "email" => $email, "telephone" => $tel);
  $collection->insert($addtab);
  echo "Utilisateur enregistre\n";
}

function	show_stud($login)
{
  $connect = new MongoClient();
  echo "Connection to database successfully\n";
  $db = $connect->mydb;
  echo "Database: mydb selected\n";
  $collection = $db->student;
  echo "Collection: student selected\n";
  $cursor = $collection->find();
  foreach ($cursor as $tab)
  {  
     echo "Login: ".$tab["_id"]."\n";
     echo "Nom: ".$tab["nom"]."\n";
     echo "Promo: ".$tab["promo"]."\n";
     echo "Email: ".$tab["email"]."\n";
     echo "Phone: ".$tab["telephone"]."\n";
     if (isset($tab["comment"]))
     echo "Commentaire:\n".'"'.trim("\n",$tab["comment"]).'"'."\n";
  }
}

function	update_stud($login)
{
  $connect = new MongoClient();
  echo "Connection to database successfully\n";
  $db = $connect->mydb;
  echo "Database: mydb selected\n";
  $collection = $db->student;
  echo "Collection: student selected\n";
  echo "Que voulez-vous modifier ?\n>";
  $mod = fopen('php://stdin', 'r');
  $mod = fgets($mod);
  if ($mod == "login\n" || $mod == "nom\n" || $mod == "email\n" ||
   $mod == "phone\n" || $mod == "telephone\n" || $mod == "comment\n")
    {
      echo "quelles modification a apporter ?\n>";
      $modif = fopen('php://stdin', 'r');
      $modif = fgets($modif);
      $modif = trim($modif,"\n");
      if ($mod == "login\n")
      $collection->update(array("_id" => $login), array('$set' => array("_id" => $modif)));
      if ($mod == "nom\n") 
      $collection->update(array("_id" => $login), array('$set' => array("nom" => $modif)));
      else if ($mod == "promo\n")
      $collection->update(array("_id" => $login), array('$set' => array("promo" => $modif)));
      else if ($mod == "email\n")
      $collection->update(array("_id" => $login), array('$set' => array("email" => $modif)));
      else if ($mod == "telephone\n" || $mod == "phone\n")
      $collection->update(array("_id" => $login), array('$set' => array("telephone" => $modif)));
      else if ($mod == "comment\n")
        $collection->update(array("_id" => $login), array('$set' => array("comment" => $modif)));
    }
  else
    echo "Veuillez choisir entre: login, nom, telephone ou phone, email et comment.\n";

}

function	add_comment($login)
{
  $connect = new MongoClient();
  echo "Connection to database successfully\n";
  $db = $connect->mydb;
  echo "Database: mydb selected\n";
  $collection = $db->student;
  echo "Collection: student selected\n";
  echo "Commentaire\n:";
  $comment = fopen('php://stdin', 'r');
  $comment = fgets($comment);
  $collection->update(array("_id" => $login), array('$set' => array("comment" => $comment)));
}

?>