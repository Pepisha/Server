# Server

Serveur de l'aplication Find Yours Pets.

## Spécifications techniques
- Serveur PHP
- Base de données MySQL
- Echange de données via JSON

## Protocole d'échange
### Login
- url : http://domaine.com/index.php
- paramètres : nickname, password, page=login
- forme réponse : {'success' => [true]/[false]}

### Register
- url : http://domaine.com/
- paramètres : nickname, password1, password2, mail, phone, firstname, lastname, page=register
- forme réponse : {'success' => [true] / [false], 'error' => 'message erreur'}
