# Server

Serveur de l'application Find Yours Pets.

## Spécifications techniques
- Serveur PHP
- Base de données MySQL
- Echange de données via JSON

## Protocole d'échange
- url : http://domaine.com/index.php

- [x] Login
  - paramètres :  page = login, nickname, password
  - forme réponse : {'success' => [true]/[false], 'isAdmin' => [true]/[false]}

- [x] Register
  - paramètres : page = register, nickname, password1, password2, mail, phone, firstname, lastname
  - forme réponse : {'success' => [true] / [false], 'error' => 'message erreur'}

- [x] GetUsers
  - paramètres : page = getUsers
  - forme réponse : {'nickname1' => User, 'nickname2' => User, ...}

- [x] UpdateUserProfile
  - paramètres : page = updateUserProfile, nickname, newPassword, confirmNewPassword, newMail, newPhone, newFirstname, newLastname
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] DeleteUser
  - paramètres : page = deleteUser, nickname
  - forme réponse : {'success' => [true]/[false]}

- [x] GetUserInformations
  - paramètres : page = getUserInformations, nickname
  - forme réponse : {'success' => [true]/[false] ,'idUser' => User, 'error' => 'message erreur'}

- [x] GetUsersAnimals
  - paramètres : page = getUsersAnimals, nickname
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] IsFollowingAnimal
  - paramètres : page = isFollowingAnimal, nickname, idAnimal
  - forme réponse : {'following' => [true]/[false]}

- [x] FollowAnimal
  - paramètres : page = followAnimal, nickname, idAnimal
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] UnfollowAnimal
  - paramètres : page = unfollowAnimal, nickname, idAnimal
  - forme réponse : {'success' => [true]/[false]}

- [x] FollowShelter
  - paramètres : page = followShelter, nickname, idAnimal
  - forme réponse : {'success' => [true]/[false], 'error' => 'messages erreur'}

- [x] GiveOpinionAboutShelter
  - paramètres : page = giveOpinionAboutShelter, idShelter, nickname, stars, description
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] GetOpinionsAboutShelter
  - paramètres : page = getOpinionsAboutShelter, idShelter
  - forme réponse : {'idOpinion1' => Opinion, 'idOpinion2' => Opinion, ...}

- [x] GetHomelessAnimals
  - paramètres : page = getHomelessAnimals
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] GetAnimal
  - paramètres : page = getAnimal, idAnimal
  - forme réponse : {'idAnimal' => Animal }

- [x] AddAnimalInShelter
  - paramètres : page = addAnimalInShelter, idShelter, type, name, breed, age, gender, catsFriend, dogsFriend, childrenFriend, description
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] ChangeAnimalsStatus
  - paramètres : page = changeAnimalsStatus, idAnimal, newStatus
  - forme réponse : {'success' => [true]/[false]}

- [x] GetAllShelters
  - paramètres : page = getAllShelters
  - forme réponse : {'idShelter1' => Shelter, 'idShelter2' => Shelter, ...}

- [x] AddShelter
  - paramètres : page = addShelter, name, phone, description, mail, website,operationalHours, street, zipcode, city, latitude, longitude
  - forme réponse : {'success' => [true]/[false]}

- [x] GetShelter
  - paramètres : page = getShelter, idShelter
  - forme réponse : {'idShelter' => Shelter}

- [x] GetSheltersAnimals
  - paramètres : page = getSheltersAnimals, idShelter
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] GetSheltersAdoptedAnimals
  - paramètres : page = getSheltersAdoptedAnimals, idShelter
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] IsAdministrator
  - paramètres : page = isAdministrator, nickname
  - forme réponse : {'admin' => [true]/[false]}

- [x] IsShelterAdministrator
  - paramètres : page = isShelterAdministrator, idShelter, nickname
  - forme réponse : {'admin' => [true]/[false]}

- [x] IsShelterManager
  - paramètres : page = isShelterManager, idShelter, nickname
  - forme réponse : {'manager' => [true]/[false]}

- [x] AddShelterAdministrator
  - paramètres : page = addShelterAdministrator, idShelter, nickname
  - forme réponse : {'success' => [true]/[false]}

- [x] AddShelterManager
  - paramètres : page = AddShelterManager, idShelter, nickname
  - forme réponse : {'success' => [true]/[false]}

- [x] GetAnimalsFollowedByUser
  - paramètres : page = getAnimalsFollowedByUser, nickname
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] GetSheltersFollowedByUser
  - paramètres : page = getSheltersFollowedByUser, nickname
  - forme réponse : {'idShelter1' => Shelter, 'idShelter2' => Shelter, ...}
