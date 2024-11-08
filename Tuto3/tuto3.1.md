Voici un tutoriel détaillé pour apprendre à utiliser **Git Submodules** dans un dépôt principal, ce qui permet d'isoler des modules dans des dépôts séparés tout en les intégrant dans le dépôt principal.

### **Prérequis**
- Vous devez avoir installé **Git** sur votre machine.
- Vous devez avoir des dépôts Git séparés pour chaque module que vous souhaitez inclure dans le dépôt principal en tant que sous-module.

---

### **1. Créer un dépôt principal**

Si vous n'avez pas encore de dépôt principal, commencez par créer un dépôt principal où vous allez inclure vos sous-modules.

#### Étapes :
1. Créez un dépôt principal (par exemple, `main-repository`).
   ```bash
   git init main-repository
   cd main-repository
   ```
2. Ajoutez un fichier `README.md` pour initialiser le dépôt :
   ```bash
   echo "# Main Repository" > README.md
   git add README.md
   git commit -m "Initial commit"
   ```
3. Poussez le dépôt principal vers un dépôt distant (par exemple, GitHub, GitLab) :
   ```bash
   git remote add origin https://github.com/username/main-repository.git
   git push -u origin master
   ```

---

### **2. Ajouter un sous-module Git (Module A)**

Un sous-module Git est un dépôt Git indépendant inclus dans un autre dépôt Git. Il est utilisé pour gérer les dépendances ou isoler certaines fonctionnalités de votre projet.

#### Étapes :
1. Dans le dépôt principal (`main-repository`), ajoutez un sous-module pour le **Module A** (par exemple, un module qui contient des fonctionnalités spécifiques).
   ```bash
   git submodule add https://github.com/username/module-a.git modules/module-a
   ```
   - Cette commande va cloner le dépôt `module-a` dans le répertoire `modules/module-a` du dépôt principal et ajouter une référence à ce sous-module dans le fichier `.gitmodules`.
2. Initialisez et mettez à jour le sous-module :
   ```bash
   git submodule init
   git submodule update
   ```

3. Après avoir ajouté le sous-module, vous devez committer les changements dans le dépôt principal :
   ```bash
   git add .gitmodules modules/module-a
   git commit -m "Ajout du sous-module Module A"
   git push origin master
   ```

---

### **3. Ajouter un deuxième sous-module Git (Module B)**

Répétez le même processus pour ajouter un autre sous-module, ici pour le **Module B**.

#### Étapes :
1. Ajoutez un sous-module pour le **Module B** :
   ```bash
   git submodule add https://github.com/username/module-b.git modules/module-b
   ```
2. Initialisez et mettez à jour le sous-module :
   ```bash
   git submodule init
   git submodule update
   ```

3. Committez les changements dans le dépôt principal :
   ```bash
   git add .gitmodules modules/module-b
   git commit -m "Ajout du sous-module Module B"
   git push origin master
   ```

---

### **4. Travailler avec les sous-modules**

Une fois que vous avez ajouté les sous-modules, vous pouvez les mettre à jour, y effectuer des changements et les synchroniser avec le dépôt principal.

#### Pour vérifier l'état des sous-modules :
```bash
git submodule status
```

#### Pour effectuer un changement dans un sous-module :
1. Allez dans le répertoire du sous-module (par exemple, `modules/module-a`).
   ```bash
   cd modules/module-a
   ```
2. Faites vos modifications dans ce module, puis commettez-les dans le dépôt du sous-module.
   ```bash
   git add .
   git commit -m "Modifications dans Module A"
   git push origin master
   ```

#### Pour mettre à jour un sous-module :
1. Revenez au dépôt principal (`main-repository`).
   ```bash
   cd ../../
   ```
2. Mettez à jour les sous-modules pour obtenir les derniers changements :
   ```bash
   git submodule update --remote
   ```

#### Pour committer un changement de sous-module dans le dépôt principal :
Lorsque vous mettez à jour ou modifiez un sous-module, Git considère cela comme un changement de référence de commit du sous-module, et non un changement direct du contenu.

1. Après avoir mis à jour un sous-module, revenez au dépôt principal.
2. Committez la mise à jour de la référence du sous-module.
   ```bash
   git add modules/module-a
   git commit -m "Mise à jour du sous-module Module A"
   git push origin master
   ```

---

### **5. Cloner un dépôt avec des sous-modules**

Si un autre développeur ou vous-même devez cloner le dépôt principal avec ses sous-modules, vous devez utiliser l'option `--recurse-submodules` pour cloner à la fois le dépôt principal et les sous-modules.

```bash
git clone --recurse-submodules https://github.com/username/main-repository.git
```

Si le dépôt est déjà cloné, vous pouvez initialiser et mettre à jour les sous-modules après coup avec les commandes suivantes :
```bash
git submodule init
git submodule update
```

---

### **6. Suppression d'un sous-module**

Si vous décidez de supprimer un sous-module, voici les étapes à suivre :

1. Supprimez le répertoire du sous-module :
   ```bash
   git submodule deinit -f modules/module-a
   rm -rf modules/module-a
   ```
2. Retirez les références au sous-module dans le fichier `.gitmodules` et l'index :
   ```bash
   git rm --cached modules/module-a
   ```
3. Committez les modifications :
   ```bash
   git commit -m "Suppression du sous-module Module A"
   git push origin master
   ```

---

### **Conclusion**

Les sous-modules Git permettent de maintenir des modules ou des dépendances dans des dépôts séparés tout en les intégrant dans un dépôt principal. Ce tutoriel vous a montré comment :

1. Ajouter des sous-modules dans un dépôt principal.
2. Effectuer des modifications et mettre à jour les sous-modules.
3. Synchroniser les sous-modules avec le dépôt principal.
4. Travailler avec des sous-modules sans perturber le reste du dépôt.

Les sous-modules sont utiles dans un scénario où vous souhaitez maintenir des composants indépendants dans des projets séparés tout en les intégrant dans un dépôt central.