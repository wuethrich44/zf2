# Studentbox

[![Build Status](https://travis-ci.org/studentbox/website.svg?branch=master)](https://travis-ci.org/studentbox/website)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/studentbox/website/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/studentbox/website/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/studentbox/website/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/studentbox/website/?branch=master)

Studentbox erleichtert dir das studieren an der HSLU. Wir bieten 
erstklassige Zusammenfassungen, alte Testate und allerlei
Tipps und Tricks, damit du angenehm durchs Semester kommst.

## Development

Unsere Plattform wurde mit dem [Zendframework 2.3](https://github.com/zendframework/zf2) entwickelt.

Wenn du dich an der Entwicklung beteiligen möchtest, reicht eine einfache IDE und ein Pull Request.

## Entwicklungsumgebung

Entwicklungsumgebung einrichten:

    cd my/project/dir
    git clone git://github.com/studentbox/website.git
    cd website
    php composer.phar self-update
    php composer.phar install

Als Datenbank verwenden wir eine MySql-Datenbank. Das Datenbankschema befindet sich im Ordner [data](data/). Dort findest du einerseits die [Struktur](data/schema.mysql.sql) und alle [Module](data/subjects.mysql.sql).

## Uploads

Wenn du deine eigenen Dokumente veröffentlichen willst, sende einfach eine Mail an upload@studentbox.ch.

Wir werden sobald als möglich auch ein Uploadform anbieten, aber zuerst kommen mal die MEP's.

## Bugs oder neue Funktionen?

Bei einem Bug oder einer Verbesserung kannst du einen [Issue](https://github.com/studentbox/website/issues) eröffnen und wir werden dein Anliegen sobald als möglich umsetzten.
