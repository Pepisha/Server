# Server

Serveur de l'application Find Yours Pets.

## Spécifications techniques
- Serveur PHP
- Base de données MySQL
- Echange de données via JSON

## Protocole d'échange
- url : http://domaine.com/index.php

### User

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

- [x] IsFollowingShelter
  - paramètres : page = isFollowingShelter, nickname, idShelter
  - forme réponse : {'following' => [true]/[false]}

- [x] FollowShelter
  - paramètres : page = followShelter, nickname, idShelter
  - forme réponse : {'success' => [true]/[false], 'error' => 'messages erreur'}

- [x] UnfollowShelter
  - paramètres : page = unfollowShelter, nickname, idShelter
  - forme réponse : {'success' => [true]/[false]}

- [x] IsAdministrator
  - paramètres : page = isAdministrator, nickname
  - forme réponse : {'admin' => [true]/[false]}

- [x] GetAnimalsFollowedByUser
  - paramètres : page = getAnimalsFollowedByUser, nickname
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] GetSheltersFollowedByUser
  - paramètres : page = getSheltersFollowedByUser, nickname
  - forme réponse : {'idShelter1' => Shelter, 'idShelter2' => Shelter, ...}

- [x] IsUserAnimalsOwner
  - paramètres : page = isUserAnimalsOwner, idAnimal, nickname
  - forme réponse : {'owner' => [true] / [false]}

- [x] GetUserPetsPreferences
  - paramètres : page = getUserPetsPreferences, nickname
  - forme réponse : {'catsFriend' => catsFriend, 'dogsFriend' => dogsFriend, 'childrenFriend' => childrenFriend, 'idType' => idType}

- [x] SetUserPetsPreferences
  - paramètres : page = setUserPetsPreferences, nickname, catsFriend, dogsFriend, childrenFriend, idType
  - forme réponse : {'success' => [true]/[false]}

- [x] GetHomePageAnimals
  - paramètres : page = getHomePageAnimals, nickname, [numberOfAnimals]
  - forme réponse : {'followedAnimals' => ['idAnimal1' => Animal, 'idAnimal2' => Animal, ...], 'suggestedAnimals' => ['idAnimal1'=> Animal, 'idAnimal2' => Animal, ...]}


### Shelters

- [x] GiveOpinionAboutShelter
  - paramètres : page = giveOpinionAboutShelter, idShelter, nickname, stars, description
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur', 'shelter' => Shelter}

- [x] GetOpinionsAboutShelter
  - paramètres : page = getOpinionsAboutShelter, idShelter, numberOfOpinions
  - forme réponse : {'idOpinion1' => Opinion, 'idOpinion2' => Opinion, ...}

- [x] GetAllShelters
  - paramètres : page = getAllShelters
  - forme réponse : {'idShelter1' => Shelter, 'idShelter2' => Shelter, ...}

- [x] AddShelter
  - paramètres : page = addShelter, name, phone, description, mail, website,operationalHours, street, zipcode, city, latitude, longitude
  - forme réponse : {'success' => [true]/[false]}

- [x] GetShelter
  - paramètres : page = getShelter, idShelter
  - forme réponse : {'success' => [true] / [false], 'shelter' => Shelter}

- [x] GetSheltersAnimals
  - paramètres : page = getSheltersAnimals, idShelter, nickname, [numberOfAnimals]
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] GetSheltersAdoptedAnimals
  - paramètres : page = getSheltersAdoptedAnimals, idShelter, nickname
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] AddAnimalInShelter
  - paramètres : page = addAnimalInShelter, idShelter, type, name, breed, age, gender, catsFriend, dogsFriend, childrenFriend, description
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] DeleteAnimalFromShelter
  - paramètres : page = deleteAnimalFromShelter, idShelter, idAnimal, nickname
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

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
  - paramètres : page = addShelterManager, idShelter, nickname
  - forme réponse : {'success' => [true]/[false]}

- [x] GetSheltersMessages
  - paramètres : page = getSheltersMessages, idShelter
  - forme réponse : {'messagesAboutShelter' => {'idMessage1' => Message, 'idMessage2' => Message, ...},
                      'messagesAboutAnimals' => {'idMessage1' => Message, 'idMessage2' => Message, ...}}

- [x] SendMessage
  - paramètres : page = sendMessage,  nickname, content, [idAnimal]
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] SetMessageRead
  - paramètres : page = setMessageRead,  idMessage


### Animals

- [x] GetHomelessAnimals
  - paramètres : page = getHomelessAnimals, nickname, [catsFriend], [dogsFriend], [childrenFriend]
  - forme réponse : {'idAnimal1' => Animal, 'idAnimal2' => Animal, ...}

- [x] getAnimalInformations
  - paramètres : page = getAnimal, idAnimal, nickname
  - forme réponse : {'animal' => Animal }

- [x] ChangeAnimalsStatus
  - paramètres : page = changeAnimalsStatus, idAnimal, newStatus, nickname
  - forme réponse : {'success' => [true]/[false]}

- [x] GetNewsFromAnimal
  - paramètres : page = getNewsFromAnimal, idAnimal
  - forme réponse : {'idNew1' => New, 'idNew2' => New, ...}

- [x] AddAnimalsNews
  - paramètres : page = addAnimalsNews, idAnimal, description
  - forme réponse : {'success' => [true]/[false], 'error' => 'message erreur'}

- [x] GetLastNewsFromAnimal
  - paramètres : page = getLastNewsFromAnimal, idAnimal
  - forme réponse : {'news' => News}

- [x] GetAnimalsOwner
  - paramètres : page = getAnimalsOwner, idAnimal
  - forme réponse : {'nickname' => ['nickname owner']/[false]}

- [x] GetMessagesAboutAnimal
  - paramètres : getMessagesAboutAnimal, idAnimal
  - forme réponse : {'message1' => Message, 'message2' => Message, ...}
