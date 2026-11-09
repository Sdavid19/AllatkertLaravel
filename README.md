# Állatkert Nyilvántartó Rendszer

Az Állatkert Nyilvántartó Rendszer egy Laravel alapú webalkalmazás, amely az állatkerti kifutók, állatok és gondozók kezelését támogatja. Az alkalmazás célja, hogy egyszerű és átlátható felületet biztosítson az állatkert napi működésének nyomon követéséhez és adminisztrációjához.

A rendszer használata bejelentkezéshez kötött, így minden funkció kizárólag hitelesített felhasználók számára érhető el. A felhasználók szerepkörök alapján eltérő jogosultságokkal rendelkeznek: az adminisztrátorok teljes körű hozzáférést kapnak, míg a gondozók kizárólag a hozzájuk tartozó kifutók és állatok adatait érhetik el.

## Főbb funkciók

### Dashboard

A főoldalon a felhasználók áttekinthetik az állatkert legfontosabb adatait:

- Kifutók száma
- Állatok száma
- Közelgő etetési feladatok listája
- Etetések időrendi sorrendben
- Csak a még esedékes etetések megjelenítése

### Kifutók kezelése

A rendszer lehetőséget biztosít a kifutók:

- Létrehozására
- Szerkesztésére
- Megtekintésére
- Törlésére

A kifutók adatlapján megjelennek:

- A kifutó adatai
- Az elhelyezhető állatok maximális száma
- A jelenleg elhelyezett állatok száma
- A kifutóhoz rendelt gondozók
- A kifutóban található állatok listája

Amennyiben egy kifutó ragadozó állatokat tartalmaz, a rendszer figyelmeztetést jelenít meg.

### Állatok kezelése

Az állatok nyilvántartása során rögzíthető:

- Név
- Faj
- Születési idő
- Kifutó
- Fénykép

Az állatok listája faj, majd születési idő szerint rendezve jelenik meg.

A rendszer biztosítja, hogy:

- Ragadozó és nem ragadozó állatok ne kerülhessenek ugyanabba a kifutóba
- A feltöltött képek a szerveren kerüljenek tárolásra
- A lecserélt képek automatikusan törlésre kerüljenek

### Archiválás

Az állatok archiválása Soft Delete segítségével valósul meg.

Archiválás esetén az állat:

- Nem kerül véglegesen törlésre
- Megjelenik az archivált állatok listájában
- Később visszaállítható egy kiválasztott kifutóba

Az archivált állatok listája tartalmazza:

- Az állat nevét
- Faját
- Az archiválás időpontját

## Jogosultságkezelés

### Adminisztrátor

- Kifutók létrehozása
- Kifutók szerkesztése
- Kifutók törlése
- Állatok létrehozása
- Állatok szerkesztése
- Állatok archiválása
- Archivált állatok visszaállítása
- Minden kifutó és állat megtekintése

### Gondozó

- Saját kifutók megtekintése
- Saját kifutók állatainak megtekintése
- Saját etetési feladatainak megtekintése

## Felhasznált technológiák

- Laravel
- PHP
- SQLite
- Blade
- Eloquent ORM
- Carbon
- Tailwind CSS
- DaisyUI

## Indítás Windows alatt

Telepítsd a PHP 8.2 vagy újabb verzióját a PDO SQLite támogatással, a Composert és a Node.js-t. Ezután a projekt gyökérkönyvtárában futtasd az `init.bat` fájlt. A parancsfájl előkészíti a függőségeket, létrehozza az SQLite adatbázist, lefuttatja a migrációkat, elkészíti a frontend fájlokat, majd elindítja a Laravel fejlesztői szervert.

Az alkalmazás a [http://127.0.0.1:8000](http://127.0.0.1:8000) címen lesz elérhető. A későbbi indítások során a parancsfájl megőrzi az adatbázis tartalmát, és csak az új migrációkat futtatja le.

## Felhasználói felület

Az alkalmazás felhasználói felülete a DaisyUI komponenskönyvtár segítségével készült, amely a Tailwind CSS-re épül. Ennek köszönhetően a rendszer modern, letisztult és reszponzív megjelenést biztosít különböző eszközökön és képernyőméreteken.
