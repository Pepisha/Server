# Server

Serveur de l'aplication Find Yours Pets. 

## Spécifications techniques
- Serveur PHP
- Base de données MySQL
- Echange de données via JSON

## Protocole d'échange
### Login 
- url : http://domaine.com/login
- paramètres : nickname, password
- forme réponse : {'connectionResult' => [true]/[false]}

