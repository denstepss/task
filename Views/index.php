<!doctype html>
<html lang="en">
<head></head>
<body>
<?php if(isset($request)) echo '<a href="/">Back link</a>'; ?>
<center>
    <form action="/search_like" method="post">
        <p><input type="search" <?php if(isset($request['search'])) echo 'value="'.$request['search'].'"'; ?>  name="search" placeholder="Search by fields Like">
            <input type="submit" value="Search"></p>
    </form>
    <form action="/strict_search" method="post">
        <input type="text" <?php if(isset($request['firstname'])) echo 'value="'.$request['firstname'].'"'; ?> placeholder="Firstname" name="firstname" >
        <input type="text" <?php if(isset($request['lastname'])) echo 'value="'.$request['lastname'].'"'; ?> placeholder="Lastname" name="lastname">
        <input type="text" <?php if(isset($request['patronymic'])) echo 'value="'.$request['patronymic'].'"'; ?> placeholder="Patronymic" name="patronymic">
        <input type="email" <?php if(isset($request['email'])) echo 'value="'.$request['email'].'"'; ?> placeholder="Email" name="email">
        <input type="number" <?php if(isset($request['sum'])) echo 'value="'.$request['sum'].'"'; ?> step=".01" placeholder="Sum" name="sum" >
        <select name="currency">
            <option value="">Choose currency</option>
            <?php
            if($currencies) {
                foreach ($currencies as $key => $currency)
                    echo '<option value="'.$key.'"'.((isset($request['currency']) && $request['currency'] == $key) ? 'selected' : '').'>'.$currency.'</option>';
            }
            ?>
        </select> <button type="submit">Strict search</button>
    </form>
<form action="/create" method="post">
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
        if(!isset($request))
            echo 'List of users</br>';
        else if(!empty($request))
            echo 'Searched users</br>';
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
        echo 'Users not found';
    }
?>
</body>
</html>