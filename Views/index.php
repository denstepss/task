<!doctype html>
<html lang="en">
<head></head>
<body>
<center>
<form action="/update" method="post">
    <p><input type="text" placeholder="Firstname" name="firstname" required></p>
    <p><input type="text" placeholder="Lastname" name="lastname" required></p>
    <p><input type="text" placeholder="Patronymic" name="patronymic" required></p>
    <p><input type="email" placeholder="Email" name="email" required></p>
    <p><input type="number" step=".01" placeholder="Sum" name="sum" required></p>
    <select name="currency" required>
        <option disabled>Choose currency</option>
        <?php
            if($currencies) {
                foreach ($currencies as $key => $currency)
                    echo '<option value="'.$key.'">'.$currency.'</option>';
            }
        ?>
    </select>
    <p><button type="submit">Создать пользователя</button></p>
</form></center>
<?php
    if(!empty($users)){
        echo 'List of users</br>';
        foreach ($users as $user){
            if($user instanceof \App\Entity\User){
                echo '<p><span>'.$user->getFirstname().'    '.
                $user->getLastname().'  '.
                $user->getPatronymic().'    '.
                $user->getEmail().'     '.
                $user->getSum().'   '.
                $user->getCurrency().'</span> <a href="/edit?id='.$user->getId().'">EDIT</a> | <a href="/delete?id='.$user->getId().'">DELETE</a> </p>';
            }
        }
    }
    else{
        echo 'Available users';
    }
?>
</body>
</html>