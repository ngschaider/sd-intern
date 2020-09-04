<p align="center">
    <a href="https://sdtriestingtal.at/" target="_blank">
        <img src="https://www.sdtriestingtal.at/wp-content/uploads/2018/02/logo-512.png" height="100px">
    </a>
    <h1 align="center">Show & Dance Management</h1>
    <br>
</p>

S&D Management ist eine Management-Software zur einfachere Verwaltung des Vereins 'Show & Dance Triestingtal'


REQUIREMENTS
------------

Für dieses Projekt wird mindestens PHP 5.6.0 vorausgesetzt.
Desweiteren ist eine MariaDB (Version 10+) notwendig.


INSTALLATION
------------

### Install manually

- Repository klonen
```
git clone https://github.com/ngschaider/sd-intern.git
```

- Abhängigkeiten installieren
```
composer install
```

- Umgebungsvariablen definieren
```
mv env.dev.example.php env.php
```
```
mv env.prod.example.php env.php
```

- Datenbankstruktur erstellen/aktualisieren
```
chmod +x ./yii
./yii migrate
```

- Den Webroot als /web festlegen
