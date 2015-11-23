# Server

Serveur de l'aplication Find Yours Pets.

## Spécifications techniques
- Serveur PHP
- Base de données MySQL
- Echange de données via JSON

## Protocole d'échange
- url : http://domaine.com/index.php

- [x] Login
  - paramètres :  page = login, nickname, password
  - forme réponse : {'success' => [true]/[false]}

- [x] Register
  - paramètres : page = register, nickname, password1, password2, mail, phone, firstname, lastname
  - forme réponse : {'success' => [true] / [false], 'error' => 'message erreur'}

- [x] UpdateUserProfile
  - paramètres : page = updateUserProfile, login, newPassword, confirmNewPassword, newMail, newPhone, newFirstname, newLastname
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [ ] DeleteUser
  - paramètres : page = deleteUser, login
  - forme réponse : {'success' => [true]/[false]}

- [ ] GetHomelessAnimals
  - paramètres : page = getHomelessAnimals
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [ ] AddAnimal
  - paramètres : page = addAnimal, type, name, breed, age, gender, catsFriend, dogsFriend, childrenFriend, description, state, idShelter
  - forme réponse : {'success' => [true]/[false]}

- [ ] ChangeAnimalsStatus
  - paramètres : page = changeAnimalsStatus, idAnimal, newStatus
  - forme réponse : {'success' => [true]/[false]}
