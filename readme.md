set up the project base 










// requirements 

users 


users

  first_name 
  last_name
  email
  role // student , admin
  status // enum [active, blocked]
  password
  remember_token
  remember_token_expires_at
  phone 
  profile
  password

  profile_photos
    id
    user_id
    image

    <?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $image = $_FILES['image'];
  echo "<pre>";
  $destination = "uploads";
  $fileName = $destination . '/' .  basename($image['name']);
  if (move_uploaded_file($image['tmp_name'], $fileName)) {
    header('Location: index.php');
    exit();
  } else {
    die("File upload Failed");
  }
}
 core php file upload script


