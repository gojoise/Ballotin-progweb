# Ballotin-progweb
Projet de prog web UpSaclay
Auteurs : Hamza, Mathieu 

## Cahier des charges 

### Terminé
- Votants authentifiés ✅
- Composition du scrutin(question/votants/réponses) ok

### A faire
1) Ajouter votants
2) Liste prédéfinie de votants
3) Sauvegarder les scrutins
4) Consulter les scrutins
5) Fermer les scrutins



## Bonus 


- Date. Vous pourrez permettre de choisir les options dans un calendrier (dates, plages
horaires). Comme le système doodle. Pour l’organisateur comme pour le votant, les plages
horaires seront affichées dans un calendrier.
- Encryption des votes. A l’aide de la librairie JSEncrypt vous pourrez encrypter les
scrutins. Un clé privé sera générée par l’organisateur qui la gardera localement. La clé
public associée sera publiée avec le scrutin et chaque votant l’utilisera pour envoyer une
version cryptée de son vote au serveur. Lors du dépouillement les votes cryptés (et mélangés)
sont tous récupérés localement sur le navigateur de l’organisateur qui décode les votes avec
sa clé privée.
- Date limite pour voter. Une date de debut et de fin pour voter pourront être mise en
place par l’organisateur. Il deviendra impossible de voter en dehors de la période prévue et
impossible de clore un scrutin avant la date de fin fixée … sauf si la participation atteint
100%.
- Interface de procuration. Plutôt que de renseigner le nombre de procurations pour
chaque votant, l’organisateur du scrutin peut simplement fixer une liste complète à l’avance
et les votants peuvent venir à l’avance indiquer qui portera leur procuration. 
