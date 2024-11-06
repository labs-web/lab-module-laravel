
Je veux que tu m'assite à développer une application très simple pour la gestion d'un blog 
qui sera comme un prototype pour expliquant comment implémenter une architecture modulaire dans une application Laravel monolithique sans utiliser de package externe pour la gestion des modules. 

L'application consiste à la création d'une application de blog avec deux modules : « GestionArticle » et « GestionCategories ». 

Dans l'application il existe deux Module : Article et Category

Article : title, content
Category: name,description

Il existe une relation Many to One:  entre Article et Category