<!doctype html>
<html lang="en">
<head></head>
<body>
<a href="/">Back link</a>
<?php if($user instanceof \App\Entity\User) { ?>
<center>
<form action="/update" method="post">
    <p><input type="text" value="<?php echo $user->getFirstname(); ?>"  name="firstname" required></p>
    <p><input type="text" value="<?php echo $user->getLastname(); ?>"  name="lastname" required></p>
    <p><input type="text" value="<?php echo $user->getPatronymic(); ?>"  name="patronymic" required></p>
    <p><input type="email" value="<?php echo $user->getEmail(); ?>"  name="email" required></p>
    <p><input type="hidden" value="<?php echo $user->getId(); ?>"  name="id"></p>
    <p><input type="number" value="<?php echo $user->getSum(); ?>" step=".01" name="sum" required></p>
    <select name="currency" required>
        <option disabled>Choose currency</option>
        <?php
            if($currencies) {
                foreach ($currencies as $key => $currency) {
                    echo '<option value="' . $key . '"'.($user->getCurrency() == $key ? 'selected' : '').'>' . $currency . '</option>';
                }
            }
        ?>
    </select>
    <p><button type="submit">Обновить пользователя</button></p>
</form></center>
<?php } ?>
</body>
</html>