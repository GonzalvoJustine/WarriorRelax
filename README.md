# WarriorRelax
Un site d'exercices physique et d'étirements personnalisable

Pour tester cette application, vous devez d'abord suivre les étapes suivantes : <br>

Clonez le dépot sur votre machine : ```git clone https://github.com/GonzalvoJustine/WarriorRelax.git```<br>
Déplacez vous dans le dossier : ```cd WarriorRelax``` <br>
Installer composer : ```composer install``` <br>
Installer npm : ```npm install``` <br>
Créez la base de données : ```php bin/console d:d:c``` <br>
Exécutez les migrations : ```php bin/console doctrine:schema:update --force``` <br>
Exécutez les fixtures : ```php bin/console doctrine:fixtures:load``` <br>
Lancez le serveur de développement : ```symfony server:start``` ou ```php -S localhost:8000 -t public``` <br>
Dans une autre console : Lancez npm : ```npm run watch``` <br>
Ouvrez le site web dans votre navigateur : ```http://localhost:8000```

Le site est prêt, vous pouvez maintenant créer vos séances !
