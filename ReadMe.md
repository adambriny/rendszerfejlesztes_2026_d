# magantanar-kereso.hu

Rendszerfejlesztés 2026, D csoport. Háromfős csapatprojekt, valós megrendelés alapján.

## 1. Összefoglaló

A magantanar-kereso.hu egy magyar nyelvű, mobilbarát weboldal, amelynek központi eleme egy oktatási platform. A felület összeköti a magántanárokat a tanulni vágyó diákokkal, és lehetővé teszi a diákok számára, hogy tantárgy, óradíj, értékelés és szabad időpontok alapján kereszenek tanárokat, valamint közvetlenül időpontot foglaljanak hozzájuk.

A rendszer két elkülönített bejelentkezési és kezelőfelületet biztosít (Tanári és Diák felület), valamint összetett szűrést, naptár- és időpontkezelést, illetve értékelési rendszert valósít meg.

**Fogalmak:**

- **RBAC (Role-Based Access Control):** Szerepkör-alapú hozzáférés-vezérlés a felhasználói jogosultságok elhatárolására.
- **Foglalás:** Egy diák által lefoglalt idősáv a kiválasztott tanár naptárában.
- **Óradíj:** A tanárok által meghatározott fix óránkénti munkadíj.

> A projekt jelen fázisban egyetemi demonstrációs célt szolgál, nem minősül működő kereskedelmi szolgáltatásnak. Éles indítás előtt jogi és megfelelőségi ellenőrzés szükséges.

## 2. A projekt bemutatása

A rendszer fő részei: egy nyilvános keresőoldal, egy diák felület, egy tanári felület, valamint egy adminisztrációs felület a moderáláshoz és felügyelethez.

### 2.1 Rendszerspecifikáció

**A felhasználói folyamat:**

1. A látogató a kezdőlapra érkezik, ahol böngészheti a tanári profilokat és elindíthatja a regisztrációt.
2. A diák vagy tanár bejelentkezik a saját felületére (`/login/student` vagy `/login/teacher`).
3. A diák a kereső és szűrő modul segítségével tantárgy, óradíj és szabad időpont szerint keres.
4. A diák kiválaszt egy szabad idősávot, és lefoglalja az órát.
5. A tanár a saját felületén megerősíti vagy visszautasítja a foglalást.
6. A megtartott óra után a diák értékelést írhat a tanárról.

**Oldaltérkép:**

| Nyilvános oldalak | Bejelentkezés utáni oldalak |
|---|---|
| Kezdőlap | Diák Irányítópult & Kereső |
| Tanárok böngészése | Tanári Profil & Időpontkezelő |
| Bejelentkezés (Diák / Tanár) | Admin Felület (Moderálás) |
| Regisztráció | Foglalások kezelése |

**Technológiák:**

| Réteg | Technológia |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Adatbázis | MySQL |
| Hitelesítés / Biztonság | Bcrypt / Argon2, Session-kezelés |

**Megjelenés:** letisztult, reszponzív kialakítás minden eszközön (Desktop, Tablet, Mobil).

### 2.2 Funkcionális követelmények

A funkcionális követelmények azt írják le, **mit tud** a rendszer.

| ID | Megnevezés | Leírás | Szerepkör | Prioritás |
|---|---|---|---|---|
| F01 | Tanári Regisztráció és Belépés | Tanárok fiókregisztrációja és bejelentkezése a tanári felületen. | Tanár | High |
| F02 | Diák Regisztráció és Belépés | Diákok fiókregisztrációja és bejelentkezése a diák felületen. | Diák | High |
| F03 | Tanári Profil Kezelése | Személyes adatok, bemutatkozó szöveg, oktatott tantárgyak és óradíjak beállítása. | Tanár | High |
| F04 | Szabad Időpontok Kezelése | Tanárok által felvitt foglalható idősávok (naptári integráció). | Tanár | High |
| F05 | Összetett Keresés & Szűrés | Tanárok listázása tantárgy, óradíj (min-max) és elérhető időpontok szerint. | Diák / Látogató | High |
| F06 | Órafoglalás | Diák által kiválasztott szabad idősáv lefoglalása. | Diák | High |
| F07 | Foglalások Állapotkezelése | Foglalások nyomon követése (Függőben / Elfogadva / Elutasítva / Lemondva). | Diák, Tanár | Medium |
| F08 | Értékelési Rendszer | Megtartott óra után a diák 1–5 csillagos értékelést és szöveges véleményt írhat. | Diák | Low |
| F09 | Adminisztrációs Moderálás | Felhasználók kezelése, visszaélések és nem megfelelő profilok moderálása. | Adminisztrátor | Medium |

### 2.3 Nem funkcionális követelmények

A nem funkcionális követelmények azt írják le, **mennyire jól és milyen feltételek mellett** működik a rendszer.

| ID | Terület | Követelmény |
|---|---|---|
| NF01 | Biztonság | Jelszavak biztonságos tárolása Bcrypt vagy Argon2 hashelési eljárással. |
| NF02 | Biztonság | Szerepkör-alapú hozzáférés-vezérlés (RBAC) a jogosulatlan hozzáférések megakadályozására. |
| NF03 | Biztonság | HTTPS protokoll használata az adatátvitel védelmére. |
| NF04 | Biztonság | Minden felhasználói bemenet escape-elve kerül megjelenítésre (XSS elleni védelem). |
| NF05 | Teljesítmény | Az adatbázis-lekérdezések válaszideje átlagos terhelés mellett ne haladja meg az 1 másodpercet. |
| NF06 | Teljesítmény | Megfelelő adatbázis indexelés a tantárgyak és időpontok gyors szűréséhez. |
| NF07 | Használhatóság | Reszponzív felület (Desktop, Tablet, Mobil nézet támogatása). |
| NF08 | Használhatóság | Áttekinthető, különálló bejelentkezési felületek a főoldalon. |
| NF09 | Jogi | A rendszer egyetemi demonstrációs célú, éles indítás előtt jogi és megfelelőségi ellenőrzés szükséges. |

## 3. Adatbázis-terv és Architektúra

### 3.1 Adatbázis Entitások (ER Modell alapok)

1. **Users**
   - `id` (PK, INT / UUID)
   - `email` (VARCHAR, Unique)
   - `password_hash` (VARCHAR)
   - `role` (ENUM: 'STUDENT', 'TEACHER', 'ADMIN')
   - `created_at` (TIMESTAMP)

2. **TeacherProfiles**
   - `id` (PK)
   - `user_id` (FK -> Users.id)
   - `bio` (TEXT)
   - `hourly_rate` (INT)
   - `rating_avg` (FLOAT)

3. **Subjects**
   - `id` (PK)
   - `name` (VARCHAR) — *pl. Matematika, Fizika, Angol, C# Programozás*

4. **TeacherSubjects**
   - `teacher_id` (FK -> TeacherProfiles.id)
   - `subject_id` (FK -> Subjects.id)

5. **Availabilities**
   - `id` (PK)
   - `teacher_id` (FK -> TeacherProfiles.id)
   - `start_time` (DATETIME)
   - `end_time` (DATETIME)
   - `is_booked` (BOOLEAN, default: false)

6. **Bookings**
   - `id` (PK)
   - `student_id` (FK -> Users.id)
   - `availability_id` (FK -> Availabilities.id)
   - `status` (ENUM: 'PENDING', 'CONFIRMED', 'CANCELLED')
   - `created_at` (TIMESTAMP)

## 4. Projekt Ütemterv és Mérföldkövek

| Mérföldkő | Feladat / Tevékenység | Státusz |
|---|---|---|
| **M1: Tervezés** | Követelményfelmérés, Projektterv.md elkészítése, DB ER-modell megtervezése. | Kész |
| **M2: Backend & DB** | Adatbázis sémák létrehozása, regisztráció/bejelentkezés (Auth) API megírása. | Folyamatban |
| **M3: Tanári Felület** | Tanári profilkezelés és szabad időpontok (Naptár) kezelésének fejlesztése. | Tervezett |
| **M4: Diák Felület** | Keresési/Szűrési felület és Órafoglalási folyamat megvalósítása. | Tervezett |
| **M5: Tesztelés & Kiadás** | Rendszertesztelés, hibajavítás, végső dokumentáció és demonstráció. | Tervezett |

## 5. Szervezeti felépítés és felelősségmegosztás

A projektet egy háromfős csapat valósítja meg. A csapat munkáját a projektmenedzser hangolja össze, aki a kapcsolattartó is az oktató felé.

### 5.1 Projektcsapat

| Név | GitHub felhasználónév | Szerepkör | Fő felelősségi terület |
|---|---|---|---|
| Idul Alexandra | @Lexa7842 | Projektmenedzser, fejlesztő | Feladatok kiosztása, ütemezés, kapcsolattartás, Adatbázis |
| Busa Sarah Michelle | @Rosebeth886 | Fejlesztő | Backend API, Adatbázis architektúra |
| Kovács Annabella | @annabellakovacs | Fejlesztő | Frontend UI/UX, Keresési és szűrési modulok |

### 5.2 Külső szereplők

| Szereplő | Szerep |
|---|---|
| Oktató | A mérföldkövek elfogadása, visszajelzés a bemutatókon. |

## 6. A munka feltételei

### 6.1 Munkakörnyezet

| Terület | Eszköz |
|---|---|
| Verziókezelés és feladatkezelés | GitHub (repository, issue-k, pull requestek, projekttábla) |
| Csapatkommunikáció | Discord |
| Kódszerkesztő | Visual Studio Code |
| Helyi fejlesztői környezet | XAMPP: Apache, PHP, MySQL |
| Bemutatási környezet | Egyetemi szerver |

**Munkamódszer:** minden feladat egy GitHub issue. Minden változtatás pull requesten keresztül kerül a fő ágba, amelyet egy másik csapattag átnéz, mielőtt elfogadják.

### 6.2 Rizikómenedzsment

| Kockázat | Hatás | Megelőzés, kezelés |
|---|---|---|
| Egy csapattag kiesik (betegség, egyéb elfoglaltság) | Csúszik a határidő | A feladatokat a projektmenedzser átosztja, a dokumentáció mindenki számára elérhető. |
| Határidő csúszása | Mérföldkő nem teljesül | A feladatokat a határidő előtt legalább egy nappal "In Review" állapotba kell hozni. |
| Ütköző változtatások ugyanabban a fájlban | Elveszett vagy összekevert munka | Egy fájlon egyszerre lehetőleg egy ember dolgozik, a pull requesteket egymás után fogadjuk el. |
| Jelszó vagy hozzáférési adat kerül a nyilvános repositoryba | Biztonsági incidens | Hozzáférési adat soha nem kerül a repositoryba, külön, a verziókezelésből kizárt konfigurációs fájlban tároljuk. |
| Jogi, megfelelőségi kérdések éles indítás esetén | A rendszer nem indítható élesben | A projekt demonstrációs célú, éles indítás előtt a megrendelő jogi ellenőrzést végeztet. |